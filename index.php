<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>John Reno Bedonia - Portfolio</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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

        /* HERO CARD / CORE SECTION CONTAINER */
        .page-section {
            display: none;
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
        }

        .page-section.active-display {
            display: block;
        }

        .page-section.fade-in {
            opacity: 1;
            transform: translateY(0);
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

        /* ------------------ HOME SECTION ------------------ */
        #home .card-container {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            align-items: center;
        }

        .hero-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
        }

        .hero-text h1 {
            font-family: var(--font-heading);
            font-weight: normal;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 10px;
            color: var(--text-white);
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
            letter-spacing: 0.5px;
        }

        .hero-text h2 {
            font-family: var(--font-body);
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--text-white);
            margin-bottom: 40px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .hero-text p {
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-white);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-visuals {
            position: relative;
            height: 480px;
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: visible;
        }

        /* Portrait Masking & Blending */
        .hero-portrait {
            position: absolute;
            bottom: -60px; /* Aligns with bottom padding edge of container */
            right: 0;
            height: 540px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            z-index: 2;
            pointer-events: none;
        }

        /* FLOATING GLOWING TECH ICONS */
        .floating-icon {
            position: absolute;
            z-index: 10;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .floating-icon:hover {
            transform: scale(1.15) !important;
            cursor: pointer;
        }

        .icon-www {
            top: 15%;
            right: 5%;
            width: 105px;
            height: 105px;
            filter: drop-shadow(0 0 20px rgba(0, 119, 230, 0.85));
            animation: float1 5s ease-in-out infinite;
        }

        .icon-js {
            bottom: 15%;
            right: 8%;
            width: 110px;
            height: 110px;
            filter: drop-shadow(0 0 20px rgba(255, 110, 0, 0.85));
            animation: float2 6s ease-in-out infinite;
        }

        .icon-html {
            top: 25%;
            left: 5%;
            width: 115px;
            height: 115px;
            filter: drop-shadow(0 0 20px rgba(255, 68, 68, 0.85));
            animation: float3 5.5s ease-in-out infinite;
        }

        /* Floating keyframes */
        @keyframes float1 {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(3deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes float2 {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(-4deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes float3 {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-18px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
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
            #home .card-container {
                gap: 30px;
            }
            .hero-text h1 {
                font-size: 2.8rem;
            }
            .hero-visuals {
                height: 400px;
            }
            .hero-portrait {
                height: 450px;
                bottom: -40px;
            }
            .floating-icon {
                transform: scale(0.85);
            }
            .floating-icon:hover {
                transform: scale(1) !important;
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
            
            /* Home Mobiles */
            #home .card-container {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }
            .hero-text {
                align-items: center;
                text-align: center;
            }
            .hero-text h1 {
                font-size: 2.3rem;
            }
            .hero-text h2 {
                margin-bottom: 25px;
                font-size: 1.1rem;
            }
            .hero-text p {
                font-size: 1rem;
            }
            .hero-visuals {
                height: 320px;
                order: 2; /* Move visual layout below text on mobile */
            }
            .hero-portrait {
                height: 360px;
                bottom: -30px;
                right: auto;
                left: 50%;
                transform: translateX(-50%);
            }
            .icon-www {
                top: 5%;
                right: 15%;
            }
            .icon-js {
                bottom: 10%;
                right: 18%;
            }
            .icon-html {
                top: 20%;
                left: 10%;
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
<body class="page-home">

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
            
            <!-- HOME SECTION -->
            <section id="home" class="page-section active-display fade-in">
                <div class="card-container">
                    <div class="hero-text">
                        <h1>JOHN RENO BEDONIA</h1>
                        <h2>Webdev / UI/UX Designer</h2>
                        <p>I'm a fresh graduate with a degree of Bachelor of Science and Information Technology. Knowledgeable in creatives and technical design skills and I'm producing visually appealing web designs and prototype materials that effectively communicate information and enhance brand identity.</p>
                    </div>
                    <div class="hero-visuals">
                        <img src="1_processed.png" alt="John Reno Bedonia Portrait" class="hero-portrait">
                        <!-- Floating Tech Icons with Drop Shadows -->
                        <img src="www_trans.png" alt="World Wide Web" class="floating-icon icon-www">
                        <img src="javascript_trans.png" alt="JavaScript" class="floating-icon icon-js">
                        <img src="html_trans.png" alt="HTML5" class="floating-icon icon-html">
                    </div>
                </div>
            </section>
        </main>

    </div>

    <!-- FOOTER Section -->
    <footer>
        <div class="footer-left">
            <div class="footer-socials">
                <!-- Social links pointing to target platforms -->
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

</body>
</html>
