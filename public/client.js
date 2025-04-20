const socket = io();

socket.on("playerNumber", (num) => {
  document.getElementById("player-info").textContent =
    "Tu es le joueur " + num + ". En attente de l'autre joueur...";
});

socket.on("full", (msg) => {
  alert(msg);
});
