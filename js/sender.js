const express = require('express');
const nodemailer = require('nodemailer');

const app = express();
const port = 3000; // or any other port you prefer

// Middleware to parse JSON request bodies
app.use(express.json());

// POST endpoint for sending emails
app.post('/send-email', (req, res) => {
    const { email } = req.body; // Assuming the request body has an 'email' field

    // Create a Nodemailer transporter
    const transporter = nodemailer.createTransport({
        service: 'Gmail', 
        auth: {
            user: 'botanguzel@hotmail.com',
            pass: 'Allahsiken21.'
        }
    });

    // Email options
    const mailOptions = {
        from: 'RecipeBox <botanguzel@hotmail.com>',
        to: email,
        subject: 'Test Email',
        text: 'This is a test email sent from Node.js with Nodemailer.'
    };

    // Send email
    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.error('Error:', error);
            res.status(500).send('Error sending email.');
        } else {
            console.log('Email sent:', info.response);
            res.status(200).send('Email sent successfully.');
        }
    });
});

// Start the server
app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});
