<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Please fill out all fields correctly."]);
        exit;
    } else {
        // Send using FormSubmit.co backend post via cURL (bypassing SSL cert issues common in XAMPP)
        $url = 'https://formsubmit.co/ajax/johnrenobedonia15@gmail.com';
        $data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message,
            '_subject' => 'New Portfolio Message!'
        );
        
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost:8080/My%20portfolio/contact.php';
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : 'http://localhost:8080';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Origin: ' . $origin,
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ));
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypasses local SSL cert validation problems in XAMPP
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_err = curl_error($ch);
        curl_close($ch);
        
        if ($result !== FALSE && $http_code >= 200 && $http_code < 300) {
            // Log successful response to verify the actual FormSubmit body
            @file_put_contents('debug_formsubmit_response.log', date('Y-m-d H:i:s') . " - Code: $http_code - Response: $result\n", FILE_APPEND);
            
            echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
            exit;
        } else {
            $log_entry = date('Y-m-d H:i:s') . " - cURL HTTP Code: $http_code - Error: $curl_err - Result: " . var_export($result, true) . "\n";
            @file_put_contents('debug_curl.log', $log_entry, FILE_APPEND);
            
            // Local fallback using standard PHP mail()
            $recipient = "johnrenobedonia15@gmail.com";
            $subject = "New Contact from $name";
            $email_content = "Name: $name\nEmail: $email\n\nMessage:\n$message";
            $email_headers = "From: $name <$email>";
            
            if (@mail($recipient, $subject, $email_content, $email_headers)) {
                echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
                exit;
            } else {
                echo json_encode(["status" => "error", "message" => "Oops! Something went wrong and we couldn't send your message."]);
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - John Reno Bedonia</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN (Custom Prefixed & Preflight Disabled for styling safety) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    
    <style>
        /* CSS RESET & VARIABLES */
        :root {
            --primary-blue: #0077E6;
            --primary-blue-hover: #0060B8;
            --bg-color: #020205;
            --card-border: rgba(0, 119, 230, 0.3);
            --text-white: #ffffff;
            --text-black: #000000;
            --input-bg: #E0E0E0;
            --font-heading: 'Alfa Slab One', serif;
            --font-body: 'Outfit', sans-serif;
            --card-glow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(0, 119, 230, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('14237505_5438810.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-white);
            font-family: var(--font-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* GLOBAL CONTAINER */
        .portfolio-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            gap: 30px;
            flex-grow: 1;
            justify-content: center;
        }

        /* HEADER NAVIGATION */
        header {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            padding-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-btn {
            font-family: var(--font-body);
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--text-white);
            background-color: var(--primary-blue);
            padding: 12px 35px;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 119, 230, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-btn:hover {
            background-color: var(--primary-blue-hover);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(0, 119, 230, 0.7);
        }

        .nav-btn:active {
            transform: translateY(0);
        }

        /* CONTROL BUTTON VISIBILITY PER PAGE STATE */
        body.page-home .nav-btn-home { display: none; }
        body.page-about .nav-btn-about { display: none; }
        body.page-contact .nav-btn-contact { display: none; }

        /* CORE SECTION CONTAINER */
        .page-section {
            width: 100%;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInPage 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes fadeInPage {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-container {
            background: linear-gradient(135deg, rgba(10, 48, 120, 0.8) 0%, rgba(5, 25, 70, 0.9) 100%);
            border: 1.5px solid var(--card-border);
            border-radius: 50px;
            box-shadow: var(--card-glow);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 60px;
            width: 100%;
            overflow: hidden;
        }

        /* ------------------ CONTACT SECTION ------------------ */
        .contact-card {
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 80px;
        }

        .contact-card h2 {
            font-family: var(--font-heading);
            font-weight: normal;
            font-size: 2.3rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 45px;
            text-shadow: 0 3px 12px rgba(0, 0, 0, 0.6);
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .input-group {
            background-color: var(--input-bg);
            border-radius: 50px;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.2);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: var(--primary-blue);
            box-shadow: 0 0 15px rgba(0, 119, 230, 0.5), inset 0 2px 6px rgba(0,0,0,0.1);
        }

        .input-group label {
            font-family: var(--font-body);
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--text-black);
            white-space: nowrap;
        }

        .input-group input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-black);
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 1.15rem;
            width: 100%;
        }

        .textarea-group {
            flex-direction: column;
            align-items: flex-start;
            border-radius: 25px;
            padding: 20px 30px;
        }

        .textarea-group label {
            margin-bottom: 12px;
        }

        .textarea-group textarea {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-black);
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 1.15rem;
            width: 100%;
            height: 150px;
            resize: none;
        }

        .submit-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .submit-btn {
            background-color: var(--primary-blue);
            color: var(--text-white);
            font-family: var(--font-body);
            font-weight: 800;
            font-size: 1.15rem;
            padding: 14px 50px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 18px rgba(0, 119, 230, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .submit-btn:hover {
            background-color: var(--primary-blue-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 119, 230, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }


        /* ------------------ FOOTER LAYOUT ------------------ */
        footer {
            background-color: var(--input-bg);
            color: var(--text-black);
            width: 100%;
            padding: 40px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        .footer-left {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .footer-socials {
            display: flex;
            gap: 18px;
        }

        .social-link {
            display: inline-block;
            border-radius: 50%;
            overflow: hidden;
            width: 46px;
            height: 46px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            background: transparent;
            transition: all 0.3s ease;
        }

        .social-link img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 0.3s, transform 0.3s;
        }

        /* Hover inverts logo colors & adds bounce effect */
        .social-link:hover {
            transform: scale(1.15) translateY(-2px);
        }

        .social-link:hover img {
            filter: invert(1);
        }

        .footer-copyright {
            font-family: var(--font-body);
            font-weight: 800;
            font-size: 1.15rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-right {
            display: flex;
            gap: 50px;
        }

        .footer-col {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .footer-col-title {
            font-family: var(--font-heading);
            font-weight: normal;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .footer-col-val {
            font-family: var(--font-heading);
            font-weight: normal;
            font-size: 1.15rem;
            color: rgba(0,0,0,0.7);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a.footer-col-val:hover {
            color: var(--primary-blue);
        }


        /* ------------------ RESPONSIVE MEDIA QUERIES ------------------ */
        @media (max-width: 1024px) {
            .card-container {
                padding: 40px;
            }
        }

        @media (max-width: 768px) {
            .portfolio-wrapper {
                padding: 20px 10px;
                gap: 20px;
            }
            header {
                justify-content: center;
                padding-right: 0;
            }
            .nav-btn {
                padding: 10px 25px;
                font-size: 0.95rem;
            }
            .card-container {
                padding: 30px 20px;
                border-radius: 35px;
            }

            /* Contact Mobiles */
            .contact-card {
                padding: 40px 20px;
            }
            .contact-card h2 {
                font-size: 1.8rem;
                margin-bottom: 30px;
            }
            .input-group {
                padding: 10px 20px;
                border-radius: 30px;
            }
            .textarea-group {
                border-radius: 20px;
            }
            .submit-btn {
                width: 100%;
                padding: 14px 20px;
            }

            /* Footer Mobiles */
            footer {
                flex-direction: column;
                gap: 30px;
                padding: 30px 20px;
                text-align: center;
            }
            .footer-left {
                align-items: center;
            }
            .footer-right {
                flex-direction: column;
                gap: 20px;
                width: 100%;
            }
        }
    </style>
</head>
<body class="page-contact">

    <div class="portfolio-wrapper">
        
        <!-- HEADER / NAVIGATION -->
        <header>
            <nav class="nav-links">
                <a href="index.php" class="nav-btn nav-btn-home">HOME</a>
                <a href="about.php" class="nav-btn nav-btn-about">ABOUT</a>
                <a href="contact.php" class="nav-btn nav-btn-contact">CONTACT</a>
            </nav>
        </header>

        <!-- MAIN CARD PORTFOLIO CONTENT -->
        <main>
            
            <!-- CONTACT SECTION -->
            <section id="contact" class="page-section">
                <div class="card-container contact-card">
                    <h2>Connect with me</h2>
                    <form class="contact-form" action="contact.php" method="POST">
                        
                        <!-- Name Field -->
                        <div class="input-group">
                            <label for="name">NAME:</label>
                            <input type="text" id="name" name="name" required autocomplete="name">
                        </div>

                        <!-- Email Address Field -->
                        <div class="input-group">
                            <label for="email">EMAIL ADDRESS:</label>
                            <input type="email" id="email" name="email" required autocomplete="email">
                        </div>

                        <!-- Message Field -->
                        <div class="input-group textarea-group">
                            <label for="message">MESSAGE HERE:</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-row">
                            <button type="submit" class="submit-btn">SUBMIT</button>
                        </div>

                    </form>
                </div>
            </section>

        </main>

    </div>

    <!-- FOOTER Section -->
    <footer>
        <div class="footer-left">
            <div class="footer-socials">
                <a href="https://github.com/Renojayy" class="social-link" title="GitHub" target="_blank" rel="noopener noreferrer">
                    <img src="github.png" alt="GitHub">
                </a>
                <a href="https://www.upwork.com/freelancers/~019bd1e8b75ef7b041" class="social-link" title="Upwork" target="_blank" rel="noopener noreferrer">
                    <img src="upwork.png" alt="Upwork">
                </a>
                <a href="https://www.facebook.com/johnreno.ix.9" class="social-link" title="Facebook" target="_blank" rel="noopener noreferrer">
                    <img src="facebook.png" alt="Facebook">
                </a>
            </div>
            <div class="footer-copyright">
                © 2026 All Rights Reserved.
            </div>
        </div>

        <div class="footer-right">
            <div class="footer-col">
                <span class="footer-col-title">Facebook</span>
                <a href="https://www.facebook.com/johnreno.ix.9" class="footer-col-val" target="_blank" rel="noopener noreferrer">John Reno</a>
            </div>
            <div class="footer-col">
                <span class="footer-col-title">Github</span>
                <a href="https://github.com/Renojayy" class="footer-col-val" target="_blank" rel="noopener noreferrer">Renojayy</a>
            </div>
            <div class="footer-col">
                <span class="footer-col-title">Upwork</span>
                <a href="https://www.upwork.com/freelancers/~019bd1e8b75ef7b041" class="footer-col-val" target="_blank" rel="noopener noreferrer">John Bedonia</a>
            </div>
        </div>
    </footer>

    <!-- TAILWIND SUCCESS/ERROR MODAL -->
    <div id="status-modal" class="tw-fixed tw-inset-0 tw-z-50 tw-hidden tw-items-center tw-justify-center tw-p-4" style="background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px);">
        <div class="tw-bg-[#0a235c] tw-border tw-border-[#0077e6]/30 tw-rounded-[30px] tw-max-w-md tw-w-full tw-p-8 tw-text-center tw-shadow-[0_20px_50px_rgba(0,0,0,0.5)] tw-transform tw-scale-95 tw-opacity-0 tw-transition-all tw-duration-300" id="modal-card">
            
            <!-- Icon Container -->
            <div id="modal-icon-box" class="tw-mx-auto tw-flex tw-items-center tw-justify-center tw-w-16 tw-h-16 tw-rounded-full tw-mb-6">
                <!-- SVG Icon gets dynamically injected -->
            </div>
            
            <!-- Modal Title -->
            <h3 id="modal-title" class="tw-font-['Outfit'] tw-font-800 tw-text-2xl tw-text-white tw-mb-2 tw-tracking-wide tw-uppercase"></h3>
            
            <!-- Modal Message -->
            <p id="modal-message" class="tw-font-['Outfit'] tw-font-600 tw-text-base tw-text-white/80 tw-mb-8 tw-leading-relaxed"></p>
            
            <button onclick="closeModal()" class="tw-font-['Outfit'] tw-font-800 tw-text-white tw-bg-[#0077e6] hover:tw-bg-[#0060b8] tw-py-3 tw-px-10 tw-rounded-full tw-shadow-[0_4px_15px_rgba(0,119,230,0.3)] hover:tw-shadow-[0_0_20px_rgba(0,119,230,0.7)] tw-transition-all tw-duration-300">
                OK
            </button>
        </div>
    </div>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        const form = document.querySelector('.contact-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'SENDING...';
            
            const formData = new FormData(form);
            
            try {
                const response = await fetch('contact.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.status === "success") {
                    showSuccessModal(data.message);
                    form.reset();
                } else {
                    showErrorModal(data.message || 'Oops! There was a problem submitting your form.');
                }
            } catch (error) {
                showErrorModal('Oops! There was a problem submitting your form.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // MODAL TOGGLE & DISPLAY FUNCTIONS
        function showSuccessModal(message) {
            const modal = document.getElementById('status-modal');
            const card = document.getElementById('modal-card');
            const iconBox = document.getElementById('modal-icon-box');
            const title = document.getElementById('modal-title');
            const msg = document.getElementById('modal-message');
            
            title.textContent = 'Success';
            msg.textContent = message;
            iconBox.className = 'tw-mx-auto tw-flex tw-items-center tw-justify-center tw-w-16 tw-h-16 tw-rounded-full tw-mb-6 tw-bg-green-500/20 tw-text-green-400 tw-border tw-border-green-500/30';
            iconBox.innerHTML = `
                <svg class="tw-w-8 tw-h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            `;
            
            modal.classList.remove('tw-hidden');
            modal.classList.add('tw-flex');
            setTimeout(() => {
                card.classList.remove('tw-scale-95', 'tw-opacity-0');
                card.classList.add('tw-scale-100', 'tw-opacity-100');
            }, 10);
        }

        function showErrorModal(message) {
            const modal = document.getElementById('status-modal');
            const card = document.getElementById('modal-card');
            const iconBox = document.getElementById('modal-icon-box');
            const title = document.getElementById('modal-title');
            const msg = document.getElementById('modal-message');
            
            title.textContent = 'Error';
            msg.textContent = message;
            iconBox.className = 'tw-mx-auto tw-flex tw-items-center tw-justify-center tw-w-16 tw-h-16 tw-rounded-full tw-mb-6 tw-bg-red-500/20 tw-text-red-400 tw-border tw-border-red-500/30';
            iconBox.innerHTML = `
                <svg class="tw-w-8 tw-h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            `;
            
            modal.classList.remove('tw-hidden');
            modal.classList.add('tw-flex');
            setTimeout(() => {
                card.classList.remove('tw-scale-95', 'tw-opacity-0');
                card.classList.add('tw-scale-100', 'tw-opacity-100');
            }, 10);
        }

        // CLOSE MODAL FUNCTION
        function closeModal() {
            const modal = document.getElementById('status-modal');
            const card = document.getElementById('modal-card');
            
            card.classList.remove('tw-scale-100', 'tw-opacity-100');
            card.classList.add('tw-scale-95', 'tw-opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('tw-flex');
                modal.classList.add('tw-hidden');
            }, 300);
        }
    </script>

</body>
</html>
