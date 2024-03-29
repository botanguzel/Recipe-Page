const express = require('express');
const bodyParser = require('body-parser');
const nodemailer = require('nodemailer');
const crypto = require('crypto');
const mysql = require('mysql2');

const app = express();
const port = 3000;

// Middleware to parse JSON bodies
app.use(bodyParser.json());

// Database connection
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'recipeXwede',
  password: '184273396Ben.',
  database: 'recipe_db'
});

connection.connect((err) => {
  if (err) {
    console.error('Error connecting to database:', err);
    return;
  }
  console.log('Connected to database');
});

// Generate a random verification code
function generateCode() {
  return crypto.randomBytes(4).toString('hex').toUpperCase();
}

// Send email with verification code and store the code in the database
app.post('/send-code', (req, res) => {
  const userEmail = req.body.email;
  const verificationCode = generateCode();

  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: 'your_email@gmail.com',
      pass: 'your_email_password'
    }
  });

  const mailOptions = {
    from: 'your_email@gmail.com',
    to: userEmail,
    subject: 'Verification Code',
    text: `Your verification code is: ${verificationCode}`
  };

  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.error('Error sending email:', error);
      res.status(500).json({ success: false, message: 'Failed to send verification code' });
    } else {
      console.log('Email sent:', info.response);

      // Store the verification code in the database
      const sql = 'UPDATE accounts SET verification_code = ? WHERE email = ?';
      connection.query(sql, [verificationCode, userEmail], (err, result) => {
        if (err) {
          console.error('Error storing verification code:', err);
          res.status(500).json({ success: false, message: 'Failed to store verification code' });
        } else {
          res.json({ success: true, message: 'Verification code sent and stored successfully' });
        }
      });
    }
  });
});

// Verify the code entered by the user
app.post('/verify', (req, res) => {
  const enteredCode = req.body.code;
  const userEmail = req.body.email;

  const sql = 'SELECT * FROM accounts WHERE email = ? AND verification_code = ?';
  connection.query(sql, [userEmail, enteredCode], (err, result) => {
    if (err) {
      console.error('Error verifying code:', err);
      res.status(500).json({ success: false, message: 'Failed to verify code' });
    } else {
      if (result.length > 0) {
        // Code is correct
        const updateSql = 'UPDATE accounts SET verification_code = NULL WHERE email = ?';
        connection.query(updateSql, [userEmail], (updateErr, updateResult) => {
          if (updateErr) {
            console.error('Error updating verification code:', updateErr);
            res.status(500).json({ success: false, message: 'Failed to update verification code' });
          } else {
            res.json({ success: true, message: 'Verification successful' });
          }
        });
      } else {
        // Code is incorrect
        res.json({ success: false, message: 'Invalid verification code' });
      }
    }
  });
});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
