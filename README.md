# Editable Table with CRUD Operations

This project is a web-based application that implements an editable table using PHP. It includes full CRUD (Create, Read, Update, Delete) functionality, allowing users to manage data directly within the table interface.

## Features

- **Editable Table Interface**: Users can edit data directly within the table.
- **CRUD Operations**:
  - Create: Add new rows to the table.
  - Read: Display data in a structured table format.
  - Update: Modify existing records directly within the table.
  - Delete: Remove unwanted rows from the table.

## Technologies Used

- **Backend**: PHP (no additional frontend frameworks or libraries used)
- **Database**: MySQL (or any other relational database)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/0Xino0/Project-Editable-Table
   ```

2. Set up the database:
   - Create a new database in your MySQL server.
   - Update the database credentials in the `connect.php` file.

3. Start the server:
   - Use a local server like XAMPP, WAMP, or MAMP.
   - Place the project folder in the `htdocs` directory (for XAMPP) or the equivalent directory for your server.

4. Access the application:
   - Open your web browser and navigate to `http://localhost/[project_folder_name]`.

## Usage

1. Open the application in your browser.
2. View the existing data displayed in the editable table.
3. Perform the following actions:
   - **Add**: Use the "Add" button to insert a new row.
   - **Edit**: Click on a cell to edit its content and save the changes.
   - **Delete**: Click the "Delete" button to remove a row.

## Folder Structure

```
project-folder/
├── connect.php      # Database connection
├── functions.php    # Helper functions
├── index.php        # Main entry point (includes AJAX and HTML)
├── action.php       # Handles CRUD operations
```

## Contributing

Contributions are welcome! Feel free to fork this repository and submit a pull request with your improvements or bug fixes.



