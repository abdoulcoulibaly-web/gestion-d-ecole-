<?php 
session_start();
require_once __DIR__ . '/config/database.php';
$pdo = getPDO();
$idEcole = 1;

$requete_actu = (function() use ($pdo,$idEcole){ $q=$pdo->prepare("SELECT * FROM actualites WHERE id_ecole = ? ORDER BY date_publication DESC LIMIT 5"); $q->execute([$idEcole]); return $q; })();
$actus = $requete_actu->fetchAll();




?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IHEM/SO - Institut des Hautes Études de Management</title>
</head>
<body>
<style>
:root {
    --primary: #003366;
    --secondary: #ffcc00;
    --white: #ffffff;
    --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

body {
    margin: 0;
    font-family: 'Poppins', Arial, sans-serif;
    overflow-x: hidden;
}

nav {
    background: var(--primary);
    padding: 0 5%;
    height: 80px;
    display: flex;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.nav-container {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--secondary);
    width: 50px;
    height: 50px;
    font-weight: 800;
    letter-spacing: 1px;
}

.nav-logo img {
    width: 50px;
    height: 50px;
    background: white;
    padding: 8px;
    border-radius: 12px;
    color: var(--primary);
    box-shadow: 0 4px 10px rgba(59, 55, 55, 0.1);
}

nav ul {
    list-style: none;
    display: flex;
    gap: 25px;
    margin: 0;
}

nav ul li a {
    color: var(--white);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: var(--transition);
    position: relative;
    padding: 5px 0;
}

nav ul li a::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 0; height: 2px;
    background: var(--secondary);
    transition: var(--transition);
}

nav ul li a:hover { color: var(--secondary); }
nav ul li a:hover::after { width: 100%; }

header {
    position: relative;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    animation: slide 30s infinite alternate;
}

.overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(0,51,102,0.8) 0%, rgba(0,20,40,0.4) 100%);
}

.header-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    padding: 20px;
}

.hero-badge {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(255, 204, 0, 0.2);
    border: 1px solid var(--secondary);
    color: var(--secondary);
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 20px;
    animation: fadeInUp 1s ease;
}

.header-content h1 {
    font-size: 4rem;
    color: white;
    margin-bottom: 20px;
    line-height: 1.1;
    animation: fadeInUp 1.2s ease;
}

.header-content h1 span { color: var(--secondary); }

.header-content p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 40px;
    animation: fadeInUp 1.4s ease;
}

.header-btns {
    display: flex;
    gap: 20px;
    justify-content: center;
    animation: fadeInUp 1.6s ease;
}

a.btn-primary {
    background: var(--secondary);
    color: var(--primary);
    padding: 15px 35px;
    font-size: 1.1rem;
    border-radius: 50px;
    box-shadow: 0 10px 20px rgba(255,204,0,0.3);
}

a.btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
    padding: 15px 35px;
    font-size: 1.1rem;
    border-radius: 50px;
}

button:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.3);
}

/* ANIMATIONS */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Petit indicateur de défilement */
.scroll-down {
    position: absolute;
    bottom: 30px;
    left: 50%;
    width: 2px; height: 50px;
    background: linear-gradient(transparent, var(--secondary));
    animation: blink 2s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 0; }
    50% { opacity: 1; }
}
/* SECTIONS */
section {
padding: 50px 10%;
text-align: center;
}
#espaces {
    background: #e6f7ff; 
    padding: 60px 10%;
}

.espaces-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    margin-top: 40px;
}

.espace-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 25px;
    width: 250px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.espace-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.espace-card h3 {
    color: #003366;
    margin-top: 0;
    margin-bottom: 15px;
}

.espace-card a {
    display: inline-block;
    background: #ffcc00;
    color: #003366;
    font-weight: bold;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background 0.3s;
}

.espace-card a:hover {
    background: #ffaa00;
}

.cta-section {
    padding: 60px 10%;
    text-align: center;
}

#preinscription {
    background-color: #f0f0f0;
}

#bourse {
    background-color: #ffffff;
}

.cta-section h2 {
    color: #003366;
    font-size: 2rem;
    margin-bottom: 20px;
}

.cta-section p {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 30px;
}

.cta-section button, .cta-section a.button {
    display: inline-block;
    background: #003366;
    color: white;
    font-weight: bold;
    border: none;
    padding: 15px 30px;
    cursor: pointer;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.cta-section button:hover, .cta-section a.button:hover {
    background: #0055aa;
}


form input, form textarea {
display: block;
width: 80%;
margin: 10px auto;
padding: 10px;
}

form button {
margin-top: 10px;
}
#apropos {
    background: #ffffff;
    padding: 100px 10%;
    overflow: hidden;
}

#apropos h2 {
    text-align: center;
    color: #003366;
    font-size: 2.8rem;
    margin-bottom: 60px;
    position: relative;
}

#apropos h2::after {
    content: '';
    display: block;
    width: 70px;
    height: 4px;
    background: #ffcc00;
    margin: 15px auto 0;
    border-radius: 2px;
}

.apropos-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 60px; 
}


.apropos-content .text {
    flex: 1.2;
    min-width: 350px;
}

.apropos-content .text p {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #444;
    margin-bottom: 25px;
    text-align: justify;
}

.apropos-content .text h3 {
    color: #003366;
    font-size: 1.6rem;
    margin-top: 35px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}


.apropos-content ul {
    list-style: none;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.apropos-content ul li {
    background: #f0f7ff;
    padding: 12px 20px;
    border-radius: 8px;
    color: #003366;
    font-weight: bold;
    font-size: 0.95rem;
    border-left: 4px solid #ffcc00;
    transition: transform 0.3s ease;
}

.apropos-content ul li:hover {
    transform: translateX(10px);
    background: #e6f0ff;
}

.apropos-content .image {
    flex: 0.8;
    position: relative;
    z-index: 1;
}

.apropos-content .image::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    width: 100%;
    height: 100%;
    border: 3px solid #ffcc00; 
    border-radius: 20px;
    z-index: -1;
}

.apropos-content .image img {
    width: 100%;
    height: auto;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    display: block;
    transition: transform 0.5s ease;
}

.apropos-content .image:hover img {
    transform: scale(1.03);
}

@media (max-width: 992px) {
    #apropos { padding: 60px 5%; }
    .apropos-content { flex-direction: column; text-align: center; }
    .apropos-content .text p { text-align: center; }
    .apropos-content .image { width: 80%; margin: 0 auto; }
}

#formations { padding: 80px 10%; background: #f4f7f6; }

.section-header { text-align: center; margin-bottom: 50px; }
.section-header h2 { color: #003366; font-size: 2.2rem; margin: 10px 0; }
.underline { width: 60px; height: 4px; background: #ffcc00; margin: 0 auto; border-radius: 10px; }

.formation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.formation-card {
    background: white;
    padding: 40px 25px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: 0.4s;
    position: relative;
    border: 1px solid #eee;
}

.formation-card:hover { transform: translateY(-10px); border-color: #ffcc00; }

.card-tag {
    position: absolute;
    top: 15px; right: 15px;
    background: #003366;
    color: white;
    padding: 5px 12px;
    font-size: 0.7rem;
    font-weight: bold;
    border-radius: 20px;
}

.card-icon { font-size: 2.5rem; color: #ffcc00; margin-bottom: 20px; }
.formation-card h3 { color: #003366; margin-bottom: 15px; }

.btn-info {
    background: #003366;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}
.btn-info:hover { background: #ffcc00; color: #003366; }

.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.7);
    backdrop-filter: blur(5px);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    padding: 40px;
    border-radius: 20px;
    width: 90%;
    max-width: 600px;
    position: relative;
    animation: zoomIn 0.3s ease;
}

@keyframes zoomIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.close-modal {
    position: absolute;
    top: 20px; right: 25px;
    font-size: 30px;
    cursor: pointer;
    color: #333;
}

#modal-body h2 { color: #003366; border-bottom: 3px solid #ffcc00; display: inline-block; margin-bottom: 20px; }
#modal-body p { line-height: 1.6; color: #555; font-size: 1.1rem; }
#modal-body ul { margin-top: 15px; }
#modal-body li { margin-bottom: 8px; font-weight: bold; color: #003366; }

#actualites {
background: #f0f8ff;
padding: 60px 10%;
text-align: center;
}

#actualites h2 {
color: #003366;
margin-bottom: 30px;
font-size: 2.2rem;
}

.slider {
position: relative;
width: 100%;
max-width: 800px;
margin: auto;
overflow: hidden;
border-radius: 15px;
box-shadow: 0px 6px 16px rgba(0,0,0,0.2);
}

.slide {
display: none;
position: relative;
}

.slide.active {
display: block;
}

.slide img {
width: 100%;
height: 400px;
object-fit: cover;
border-radius: 15px;
}

.caption {
position: absolute;
bottom: 20px;
left: 20px;
background: rgba(0, 51, 102, 0.7);
color: white;
padding: 15px;border-radius: 8px;
max-width: 70%;
text-align: left;
}

.caption h3 {
margin: 0;
font-size: 1.5rem;
margin-bottom: 5px;
}

.caption p {
margin: 0;
font-size: 1rem;
}

.slider-buttons {
margin-top: 15px;
}

.slider-buttons button {
background: #003366;
color: white;
border: none;
padding: 10px 15px;
font-size: 1.5rem;
margin: 0 5px;
border-radius: 50%;
cursor: pointer;
transition: 0.3s;
}

.slider-buttons button:hover {
background: #0055aa;
}

#contact {
    background: #f9f9f9;
    padding: 80px 10%;
}

#contact h2 {
    text-align: center;
    margin-bottom: 15px;
    color: #003366;
    font-size: 2.2rem;
}

#contact .intro {
    text-align: center;
    margin-bottom: 40px;
    font-size: 1.1rem;
    color: #555;
}

.contact-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: center;
    align-items: stretch;
}

.info-block {
    flex: 1;
    min-width: 320px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 6px 16px rgba(0,0,0,0.08);
    border-left: 5px solid #ffcc00; 
}

.info-card h3 {
    margin: 0 0 10px 0;
    color: #003366;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-card p {
    margin: 0;
    line-height: 1.6;
    color: #444;
}

.horaires-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.horaires-list li {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
    border-bottom: 1px dashed #eee;
}

.horaires-list li:last-child {
    border-bottom: none;
}

.horaires-list span:first-child {
    font-weight: bold;
    color: #003366;
}

.map {
    flex: 1.2;
    min-width: 320px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0px 6px 16px rgba(0,0,0,0.15);
    height: auto;
}

.map iframe {
    height: 100%;
    min-height: 350px;
}

@media (max-width: 768px) {
    .contact-grid {
        flex-direction: column;
    }
}

#site-footer {
    background: #002244; 
    color: #ffffff;
    padding: 60px 10% 20px;
    font-family: 'Poppins', sans-serif;
}

.footer-container {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
    justify-content: space-between;
}

.footer-col {
    flex: 1;
    min-width: 250px;
}

.footer-col h3 {
    color: #ffcc00;
    font-size: 1.8rem;
    margin-bottom: 20px;
    font-weight: 800;
}

.footer-col h4 {
    color: #ffcc00;
    font-size: 1.2rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}

.footer-col h4::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 40px; height: 3px;
    background: #ffcc00;
}

.contact-info p {
    margin: 10px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-col a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: 0.3s;
}

.footer-col a:hover {
    color: #ffcc00;
}

.partners ul {
    list-style: none;
    padding: 0;
}

.partners li {
    margin-bottom: 12px;
}

.partners i {
    font-size: 0.8rem;
    color: #ffcc00;
    margin-right: 8px;
}

.social-icons {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.icon {
    width: 45px;
    height: 45px;
    border-radius: 12px; 
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: white !important;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.icon.wa { background: #25D366; }
.icon.fb { background: #1877F2; }
.icon.gm { background: #EA4335; } 
.icon.tt { background: #000000; }

.icon:hover {
    transform: translateY(-8px) rotate(8deg);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

.follow-note {
    font-size: 0.9rem;
    opacity: 0.7;
    font-style: italic;
}

.footer-bottom {
    margin-top: 50px;
    padding-top: 25px;
    border-top: 1px solid rgba(255,255,255,0.1);
    text-align: center;
}

.footer-bottom p {
    margin: 5px 0;
    font-size: 0.9rem;
    opacity: 0.8;
}

.designer span {
    color: #ffcc00;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

@media (max-width: 768px) {
    .footer-container { flex-direction: column; text-align: center; }
    .footer-col h4::after { left: 50%; transform: translateX(-50%); }
    .social-icons { justify-content: center; }
    .contact-info p { justify-content: center; }
}
@media (max-width: 820px) {
  .footer-container {
flex-direction: column;
align-items: center;
text-align: center;
 }

.footer-col {

min-width: 100%;

}
.social-icons {
 justify-content: center;
 }
}

.modal {
display: none;
position: fixed;
z-index: 999;
left: 0; top: 0;
width: 100%; height: 100%;
background: rgba(0,0,0,0.6);
justify-content: center;
align-items: center;
}

.modal-content {
background: #fff;
padding: 25px;
border-radius: 12px;
max-width: 600px;
width: 90%;
box-shadow: 0 8px 20px rgba(0,0,0,0.25);
animation: zoomIn 0.3s ease;
}

.modal-content h3 {
margin-top: 0;
color: #003366;
}

.modal-content p {
color: #333;
line-height: 1.6;
}

.close {
float: right;
font-size: 28px;
cursor: pointer;
color: #555;
}

.close:hover {
color: #000;
}
@keyframes zoomIn {
from { transform: scale(0.7); opacity: 0; }
to { transform: scale(1); opacity: 1; }
}
</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<nav>
    <div class="nav-container">
        <div class="nav-logo">
            <img src="OIP.webp" alt="logo">
            <span>IHEM/SO</span>
        </div>
        
        <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#apropos">À propos</a></li>
            <li><a href="#formations">Formations</a></li>
            <li><a href="#preinscription">Pré-inscription</a></li>
            <li><a href="#bourse">Bourse</a></li>
            <li><a href="#actualites">Actualités</a></li>
            <li class="dropdown-link"><a href="#espaces">Espaces ▼</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
</nav>

<header id="slideshow">
    <div class="overlay"></div>
    <div class="header-content">
        <div class="hero-badge">Excellence & Avenir</div>
        <h1>Bienvenue à l'<span>IHEM/SO</span></h1>
        <p>L'institut qui forme les futurs leaders en management et informatique.</p>
        <div class="header-btns">
            <a href="#formations" class="btn-primary">formation</a>
           <a href="#contact" class="btn-secondary">contact</a>    
            </div>
    </div>
    <div class="scroll-down"></div>
</header>

        <section id="apropos">
        <div class="container">
        <h2>À propos de l'IHEM/SO</h2>
        <div class="apropos-content">
            <div class="text">
                <p>
                    L’Institut des Hautes Études de Management Samuel Ouli (IHEM/SO) est une grande école située à Abidjan, 
                    dédiée à la formation de futurs leaders en <strong>management</strong>, <strong>finance</strong>, 
                    <strong>marketing</strong> et <strong>informatique</strong>. 
                </p>

                <p>
                    Notre mission est de fournir une éducation de qualité, adaptée aux défis du marché mondial, 
                    en formant des étudiants compétents, innovants et prêts à relever les défis de demain.
                </p>

                <h3>Notre vision</h3>
                <p>
                    Être une référence en Afrique dans la formation académique et professionnelle, 
                    en développant une nouvelle génération de managers et d’entrepreneurs.
                </p>
                <h3>Nos valeurs</h3>
                <ul>
                    <li>Excellence académique</li>
                    <li>Innovation et créativité</li>
                    <li>Intégrité et responsabilité</li>
                    <li>Ouverture sur le monde</li>
                </ul>
            </div>

            <div class="image">
                <img src="ih.jpg" alt="Campus IHEM/SO">
            </div>
        </div>
    </div>   </section>

   <section id="formations">
  <div class="container">
    <div class="section-header">
        <span class="subtitle">Nos Filières d'Excellence</span>
        <h2>BTS - LICENCE - MASTER</h2>
        <div class="underline"></div>
    </div>

    <div class="formation-grid">
      <div class="formation-card">
        <div class="card-tag">BTS / L / M</div>
        <div class="card-icon"><i class="fas fa-laptop-code"></i></div>
        <h3>Informatique (IDA)</h3>
        <p>Développement d'Applications, Cybersécurité et Réseaux Informatiques.</p>
        <button class="btn-info" data-id="ida">Voir le programme</button>
      </div>

      <div class="formation-card">
        <div class="card-tag">BTS / L / M</div>
        <div class="card-icon"><i class="fas fa-calculator"></i></div>
        <h3>Gestion & Finance (FCG / GEC)</h3>
        <p>Comptabilité, Audit, Gestion des Entreprises et Contrôle de Gestion.</p>
        <button class="btn-info" data-id="finance">Voir le programme</button>
      </div>

      <div class="formation-card">
        <div class="card-tag">BTS / L / M</div>
        <div class="card-icon"><i class="fas fa-users-cog"></i></div>
        <h3>RH & Communication (RHCOM)</h3>
        <p>Gestion des Ressources Humaines et Stratégies de Communication.</p>
        <button class="btn-info" data-id="rhcom">Voir le programme</button>
      </div>
    </div>
  </div>
</section>

<div id="formation-modal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div id="modal-body">
        </div>
  </div>
</div>
<section id="preinscription" class="cta-section">
    <div class="container">
        <h2>Processus de Pré-inscription</h2>
        <p>Commencez votre parcours à l'IHEM/SO en remplissant notre formulaire de pré-inscription en ligne. C'est la première étape vers votre réussite !</p>
        <a href="preinscription.php" class="button" target="_blank">
            Démarrer ma pré-inscription
        </a>
    </div>
</section>
<section id="bourse" class="cta-section">
    <div class="container">
        <h2>Candidater pour la Bourse IHEM/SO</h2>
        <p>L'IHEM/SO s'engage pour l'excellence. Découvrez les critères d'éligibilité et soumettez votre dossier pour bénéficier d'une aide financière.</p>
        <a href="bourses.php" class="button" target="_blank">
            En savoir plus et postuler
        </a>
    </div>
</section>
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close">×</span>
    <h3 id="modal-title"></h3>
    <p id="modal-text"></p>
  </div>
</div>


    <section id="actualites">
    <div class="container">
        <h2>Actualités & Événements</h2>
        <div class="slider">
            
            <?php if (count($actus) > 0): ?>
                <?php foreach($actus as $index => $a): ?>
                    <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                     <img src="uploads/<?= htmlspecialchars($a['image_url']) ?>" alt="<?= htmlspecialchars($a['titre']) ?>">                        
                        <div class="caption">
                            <h3><?= htmlspecialchars($a['titre']) ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune actualité pour le moment.</p>
            <?php endif; ?>

        </div>

        <div class="slider-buttons">
            <button onclick="prevSlide()">❮</button>
            <button onclick="nextSlide()">❯</button>
        </div>
    </div>
</section>

<section id="espaces">
    <div class="container">
        <h2>Espaces Utilisateurs</h2>
        <p class="intro">Accédez rapidement à votre portail personnel (emplois du temps, notes, ressources...).</p>
        <div class="espaces-grid">
            <div class="espace-card">
                <h3>Espace Étudiant 🎓</h3>
                <p>Votre portail pour notes, cours et informations administratives.</p>
                <a href="connexion.php" target="_blank">Se connecter</a>
            </div>

            <div class="espace-card">
                <h3>Espace Professeur 👨‍🏫</h3>
                <p>Accès aux outils pédagogiques et de gestion des classes.</p>
                <a href="connexion.php" target="_blank">Se connecter</a>
            </div>

            <div class="espace-card">
                <h3>Espace Administrateur ⚙️</h3>
                <p>Outils de gestion du personnel et des dossiers de l'école.</p>
                <a href="connexion.php" target="_blank">Se connecter</a>
            </div>
        </div>
    </div>
</section>
   <section id="contact">
    <div class="container">
        <h2>Nous Trouver</h2>
        <p class="intro">Visitez notre campus au cœur d'Abidjan pour toute information complémentaire ou inscription.</p>

        <div class="contact-grid">
            <div class="info-block">
                <div class="info-card">
                    <h3><i class="fas fa-map-marker-alt"></i> Localisation</h3>
                    <p>IHEM/SO Campus Abidjan<br>Cocody Angré, 7ème Tranche<br>Abidjan, Côte d'Ivoire</p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-clock"></i> Horaires d'Ouverture</h3>
                    <ul class="horaires-list">
                        <li><span>Lundi - Vendredi :</span> <span>08h00 – 18h00</span></li>
                        <li><span>Samedi :</span> <span>09h00 – 13h00</span></li>
                        <li><span>Dimanche :</span> <span>Fermé</span></li>
                    </ul>
                </div>
                
                <div class="info-card">
                    <h3><i class="fas fa-phone-alt"></i> Contact Direct</h3>
                    <p>Secrétariat : +225 00 00 00 00 00<br>Email : contact@ihemso.ci</p>
                </div>
            </div>

            <div class="map">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.24756854123!2d-3.985!3d5.38!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMjInNDguMCJOIDPCsDU5JzA2LjAiVw!5e0!3m2!1sfr!2sci!4v1620000000000" 
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>
    <script>
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: "smooth" });
}

document.getElementById("contactForm").addEventListener("submit", function(e){
    e.preventDefault();
    const name = document.getElementById("name").value;
    document.getElementById("response").innerText = 
        `Merci ${name}, votre message a été envoyé !`;
    this.reset();
});
let currentSlide = 0;
const slides = document.querySelectorAll(".slide");

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === index) slide.classList.add("active");
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}


setInterval(nextSlide, 5000);
showSlide(currentSlide);

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: "smooth" });
}


<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("formation-modal");
    const modalBody = document.getElementById("modal-body");
    const closeBtn = document.querySelector(".close-modal");
    const data = {
        ida: {
            title: "Informatique (IDA)",
            text: "Le BTS IDA forme des techniciens capables de concevoir et développer des applications. En Licence et Master, nous approfondissons le Cloud, l'Intelligence Artificielle et la Cybersécurité.",
            filiere: ["Développement Web & Mobile", "Réseaux et Sécurité", "Génie Logiciel"]
        },
        finance: {
            title: "Gestion & Finance (FCG / GEC)",
            text: "Cette filière couvre la gestion comptable et financière des entreprises. De l'audit au contrôle de gestion, devenez un pilier stratégique pour toute organisation.",
            filiere: ["Comptabilité Générale", "Audit et Fiscalité", "Finance de Marché"]
        },
        rhcom: {
            title: "RH & COM (RHCOM)",
            text: "Maîtrisez l'art de la communication institutionnelle et la gestion humaine. Formez-vous aux enjeux du recrutement, de la paie et du marketing d'influence.",
            filiere: ["Ressources Humaines", "Communication Digitale", "Relations Publiques"]
        }
    };

    document.querySelectorAll(".btn-info").forEach(btn => {
        btn.onclick = function() {
            const id = this.getAttribute("data-id");
            const info = data[id];
            
            if (info) {
                modalBody.innerHTML = `
                    <h2 style="color:#003366; border-bottom:3px solid #ffcc00; display:inline-block;">${info.title}</h2>
                    <p style="margin-top:20px; line-height:1.6;">${info.text}</p>
                    <p><strong>Niveaux disponibles :</strong> BTS, LICENCE, MASTER</p>
                    <ul style="list-style:none; padding:0;">
                        ${info.filiere.map(item => `<li style="margin-bottom:8px;">✔️ ${item}</li>`).join('')}
                    </ul>
                `;
                modal.style.display = "flex";
            }
        };
    });

    
    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>
<div id="formation-modal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div id="modal-body">
        </div>
  </div>
</div>
</body>
<footer id="site-footer">
  <div class="footer-container">
    <div class="footer-col about">
      <h3>IHEM/SO</h3>
      <p>
        Institut des Hautes Études de Management Samuel Ouli<br>
        <strong>Abidjan — Côte d'Ivoire</strong>
      </p>
      <div class="contact-info">
        <p><i class="fas fa-envelope"></i> <a href="mailto:contact@ihemso.ci">contact@ihemso.ci</a></p>
        <p><i class="fas fa-phone-alt"></i> <a href="tel:+22500000000">+225 07 00 00 00 00</a></p>
      </div>
    </div>

    <div class="footer-col partners">
      <h4>Nos Partenaires</h4>
      <ul>
        <li><a href="#" target="_blank"><i class="fas fa-handshake"></i> M-Groupe</a></li>
        <li><a href="#" target="_blank"><i class="fas fa-handshake"></i> Bloom Côte d'Ivoire</a></li>
      </ul>
    </div>

    <div class="footer-col social">
      <h4>Retrouvez-nous</h4>
      <div class="social-icons">
        <a class="icon wa" href="https://wa.me/2250700000000" target="_blank" aria-label="WhatsApp">
          <i class="fab fa-whatsapp"></i>
        </a>
        <a class="icon fb" href="https://facebook.com/VOTRE_PAGE" target="_blank" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a class="icon gm" href="mailto:contact@ihemso.ci" aria-label="Gmail">
          <i class="fas fa-envelope"></i>
        </a>
        <a class="icon tt" href="#" target="_blank" aria-label="TikTok">
          <i class="fab fa-tiktok"></i>
        </a>
      </div>
      <p class="follow-note">Rejoignez notre communauté en ligne.</p>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2026 <strong>IHEM/SO</strong> — Tous droits réservés.</p>
    <p class="designer">Propulsé par <span>Néné Doua Prince Registre</span></p>
  </div>
</footer>
</html>