const bcrypt = require('bcrypt');

function hashPassword(password) {
  const saltRounds = 10;
  const salt = bcrypt.genSaltSync(saltRounds);
  const hashed = bcrypt.hashSync(password, salt);
  return hashed;
}

// Example usage
const plainPassword = 'Bakar&bro1';
const hashedPassword = hashPassword(plainPassword);
console.log(hashedPassword);