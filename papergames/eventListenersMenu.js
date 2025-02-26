// Menu event listeners
document.getElementById('vs-computer-btn').addEventListener('click', () => {
    document.getElementById('menu-screen').classList.remove('active');
    document.getElementById('game-screen').classList.add('active');
    new BatailleNavale('vs-computer', 'Joueur', 'Ordinateur');
});

document.getElementById('pvp-btn').addEventListener('click', () => {
    document.getElementById('menu-screen').classList.remove('active');
    document.getElementById('player-names-screen').classList.add('active');
});

document.getElementById('tournament-btn').addEventListener('click', () => {
    document.getElementById('menu-screen').classList.remove('active');
    document.getElementById('game-screen').classList.add('active');
    new BatailleNavale('tournament', 'Joueur 1', 'Joueur 2');
});

// Player names screen events
document.getElementById('start-pvp-game').addEventListener('click', () => {
    const player1Name = document.getElementById('player1-name').value || 'Joueur 1';
    const player2Name = document.getElementById('player2-name').value || 'Joueur 2';
    
    document.getElementById('player-names-screen').classList.remove('active');
    document.getElementById('game-screen').classList.add('active');
    
    new BatailleNavale('pvp', player1Name, player2Name);
});

document.getElementById('back-to-menu-from-names').addEventListener('click', () => {
    document.getElementById('player-names-screen').classList.remove('active');
    document.getElementById('menu-screen').classList.add('active');
});