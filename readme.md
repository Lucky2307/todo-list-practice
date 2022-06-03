# todo-list-practice
Made a website to practice implement PHP-MySQL

### Preview
<p align="center"><img src="./img/desktop.png?raw=true" alt="Desktop view" width=80%/></p>
<p align="center"><img src="./img/desktopmodal.png?raw=true" alt="Desktop modal view" width=80%/></p>
<p float="left" align="center">
<img src="./img/mobile.png?raw=true" alt="Mobile modal view" width=40%/>
<img src="./img/mobilemodal.png?raw=true" alt="Mobile modal view" width=40%/>
</p>

### How the page works:
- Files:
    - dbActions.php: Contains function with actions relating to the database.
    - dbConnect.php: Contains connection info to the database. User and password are taken from the system environment as MySqlUser and MySqlPassword respectively.
    - todo.php: The index page.
- Load: 
    - When the page is loaded, a function will be called to fill the content with the data from the database using an AJAX call to the dbActions.php file.
    - The table header is prebuilt in the html, and the content rows are built within the AJAX call.
    - When the call is done, the number count is set using javascript by counting the number of rows in the table. (Subject to change)

- Add:
    - A modal will show up as a form of confirmation.
    - When it is confirmed, the page will send an AJAX call to add the form data to the database.
    - Call the fill table action to refresh the database.

- Remove:
    - Each rows is equipped with a remove button with information on its ID in the database.
    - A modal will shop up as a form of confirmation.
    - When confirmed, the page will send an AJAX call to remove the data from the database.

### To do list:
- Add edit data
- Color code table row according to how close to deadline
- Make duplicate detection
- Change deadline to Date & Time format(?)
- Change number count set method to a separate call so that paging is possible
- Move add form to somewhere else so that it doesn't get pushed down
- Change data passing system from attributes to hidden formData(?)
- Migrate all pure JS to JQuery
- ~~Style page~~
- Tidy up
