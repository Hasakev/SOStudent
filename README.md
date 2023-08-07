# SOStudent
A student discussion board created in PHP using CI4 framework. 

This app was created during INFS3202 - Web Information Systems course at UQ during 2023 Semester 1 - (February 2023 - June 2023). This project was developed in one month under a deep schedule (see [ProjectProposal.pdf](https://github.com/Hasakev/SOStudent/blob/main/ProjectProposal.pdf)) This project received full marks. (45/45)

You can find a deployed version here: [UQCloud](https://infs3202-e717fd19.uqcloud.net/)

- Frontend: HTML, CSS, JavaScript, Bootstrap
- Backend: PHP, CodeIgniter 4
- Database: MySQL

Many libraries were used, these include:
- [Bootstrap](https://getbootstrap.com/)
- [JQuery](https://jquery.com/)
- [JQuery UI](https://jqueryui.com/)
- [Dropzone.js](https://www.dropzonejs.com/)
- [Imagick](https://www.php.net/manual/en/book.imagick.php)
- [Google reCAPTCHA](https://www.google.com/recaptcha/about/)

## Installation (Local)
1. Clone the repository
2. Download and install [XAMPP](https://www.apachefriends.org/index.html)
3. Start Apache and MySQL in XAMPP
4. Open phpMyAdmin and import the database file `SOSStudent.sql`
5. Open the project folder in your IDE and run `php spark serve` in the terminal
6. Open `localhost:8080` in your browser

## Deploying to UQCloud
1. Clone the repository
2. Save the repository in `var/www/htdocs/[index_directory]` folder in your UQCloud account
3. Open phpMyAdmin and import the database file `SOSStudent.sql`
4. Accessing https://infs3202-########.uqcloud.net/[index_directory] should now show the website

## Basic Features
- Remember me: Users can choose to be remembered for 30 days
- User profile updating: Users can update their profile information
- Web security: Passwords are hashed and salted
- Questions: Author can post and delete questions
- Favourites: Users can favourite questions
- Basic file upload: Users can upload files to questions
- Add comments: Users can add comments to questions
- Image processing: Images are resized and compressed before being uploaded (Imagick)
- Authorisation: Redirect to login page if not logged in and back to previous page after login
- Drag and drop: Users can drag and drop files to upload (Dropzone.js)
- Multiple file upload: Users can upload multiple files at once (Dropzone.js)
- Web Security: recaptcha v2 is used to prevent bots from spamming (Google)
- Search box autocomplete: Users can search for questions (JQuery UI)
- Sophisticated UI Design: The website is responsive and looks good on all devices (Bootstrap)

## Intermediate Features
- Email Verification: Users must verify their email before they can login
- Password Reset: Users can reset their password if they forget it
- Bookmark Questions: Users can bookmark questions
- Search: Users can search for questions (JQuery)

## Advanced Features
Recommendation System: Users are recommended questions based on their interests and previous questions they have viewed. (Self-developed algorithm)
