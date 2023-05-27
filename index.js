const express = require('express');
const cookieParser = require('cookie-parser');

const app = express();
app.use(cookieParser());

app.get('/user', (req, res) => {

  const permission = req.cookies.permission;

  const id_user = req.cookies.id_user;

  console.log('id_user:', id_user); 

  if (permission === 'admin') {

    res.redirect('http://localhost/logistic_drone/admin/admin.php');
  } else if (permission === 'user') {
    res.redirect('http://localhost/logistic_drone/user/user.php');
  } else {
    res.send('Erreur : permission invalide');
  }
});

app.listen(3003, () => {
  console.log('Serveur démarré sur le port 3003');
});
