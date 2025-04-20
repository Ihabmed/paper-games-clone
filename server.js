const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = new Server(server);

app.use(express.static("public"));

let players = [];

io.on("connection", (socket) => {
  console.log("Nouveau joueur connecté :", socket.id);

  if (players.length < 2) {
    players.push(socket);
    socket.emit("playerNumber", players.length);
  } else {
    socket.emit("full", "La partie est complète !");
    socket.disconnect();
    return;
  }

  socket.on("fire", (data) => {
    players.forEach((s) => {
      if (s.id !== socket.id) s.emit("enemyFire", data);
    });
  });

  socket.on("response", (data) => {
    players.forEach((s) => {
      if (s.id !== socket.id) s.emit("fireResult", data);
    });
  });

  socket.on("disconnect", () => {
    players = players.filter((s) => s.id !== socket.id);
    console.log("Joueur déconnecté :", socket.id);
  });
});

server.listen(3000, () => {
  console.log("Serveur lancé sur http://localhost:3000");
});
