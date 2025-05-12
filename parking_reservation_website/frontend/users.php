<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Users - PARKER</title>
</head>
<body>
  <h2>Users</h2>
  <table id="userTable">
    <thead>
    </thead>
    <tbody>
    </tbody>
  </table>

  <script>
    // Function to fetch and display user data
    function getUsers() {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'get_users.php', true); // Replace with the actual path to your backend script (within the same file)
      xhr.onload = function() {
        if (xhr.status === 200) {
          const userData = JSON.parse(xhr.responseText);
          const tableBody = document.getElementById('userTable').getElementsByTagName('tbody')[0];

          // Clear existing table rows
          tableBody.innerHTML = '';

          // Loop through user data and populate table rows
          for (let i = 0; i < userData.length; i++) {
            const user = userData[i];
            const row = document.createElement('tr');

            const firstNameCell = document.createElement('td');
            firstNameCell.textContent = user.first_name;
            row.appendChild(firstNameCell);

            const lastNameCell = document.createElement('td');
            lastNameCell.textContent = user.last_name;
            row.appendChild(lastNameCell);

            const emailCell = document.createElement('td');
            emailCell.textContent = user.email;
            row.appendChild(emailCell);

            tableBody.appendChild(row);
          }
        } else {
          console.error('Error fetching users:', xhr.statusText);
          // You can display an error message to the user here
        }
      };
      xhr.send();
    }

    // Call the getUsers function on page load
    getUsers();
  </script>

  <?php

  // Include database connection details (**Security Risk: Consider a separate file**)
  $db_hostname = 'localhost';
  $db_username = 'root';
  $db_password = ''; // No password (not recommended for production)
  $db_database = 'parking_reservation_website';

  // Create connection
  $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // SQL query to fetch all users (updated for your table structure)
  $sql = "SELECT first_name, last_name, email FROM users";
  $result = $conn->query($sql);

  $userData = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $userData[] = $row;
    }
  }

  // Encode user data as JSON
  $jsonData = json_encode($userData);

  echo $jsonData;

  $conn->close();

  ?>
</body>
</html>
