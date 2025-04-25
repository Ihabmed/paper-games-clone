document.getElementById('vs-computer-btn').addEventListener('click', () => {
    document.getElementById('menu-screen').classList.remove('active');
    document.getElementById('classement').style.display = 'none';
    document.getElementById('bienvenue').style.display = 'none';
    document.getElementById('profile_pic').classList.remove('active');
    document.getElementById('game-screen').classList.add('active');
    new BatailleNavale('vs-computer', 'Joueur', 'Ordinateur');
});

document.getElementById('back-to-menu').addEventListener('click', () => {
    document.getElementById('bienvenue').style.display = '';
    document.getElementById('classement').style.display = 'block';
    document.getElementById('profile_pic').classList.add('active');
    document.getElementById('classemnt').style.position = 'relative';
    document.getElementById('game-screen').classList.remove('active');
    document.getElementById('menu-screen').classList.add('active');
});