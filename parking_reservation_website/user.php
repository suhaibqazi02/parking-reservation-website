<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Users - PARKER</title>
  <style>
    /* General body reset and base font */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7f6;
        color: #333;
        line-height: 1.6;
    }

    /* Consistent Nav Styling */
    nav {
        background-color: #2c3e50;
        color: #fff;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    nav .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .logo {
        font-size: 1.8rem;
        margin: 0;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
    }
    .nav-links {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
    }
    .nav-links li {
        margin-left: 25px;
    }
    .nav-links li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.95rem;
    }
    .nav-links li a:hover, .nav-links li a.active {
        color: #e67e22;
    }
    /* End Nav Styling */

    .page-container { /* Main content container */
        width: 90%;
        max-width: 1000px; /* Wider for admin content */
        margin: 30px auto;
        padding: 20px;
    }

    h2 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 1.8rem;
        font-weight: 600;
    }

    /* Table Styles */
    #userTableContainer {
        background-color: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    table#userTable {
        width: 100%;
        border-collapse: collapse;
    }

    #userTable th, #userTable td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    #userTable th {
        background-color: #34495e;
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
    }

    #userTable tr:last-child td {
        border-bottom: none;
    }

    #userTable tr:hover {
        background-color: #f9f9f9;
    }

    #userTable td {
        font-size: 0.9rem;
        color: #444;
    }
    .error-message {
        color: red;
        text-align: center;
        padding: 10px;
    }
  </style>
</head>
<body>
  <nav>
    <div class="container">
        <a href="admin.html" class="logo">PARKER - View Users</a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="admin.html">Admin Dashboard</a></li>
            <li><a href="logout.php" id="logoutBtn" class="nav-button">Logout</a></li>
        </ul>
    </div>
  </nav>

  <div class="page-container">
    <h2>User List</h2>
    <div id="userTableContainer">
      <table id="userTable">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <p id="userLoadingError" class="error-message" style="display:none;"></p>
    </div>
  </div>

  <script>
    function getUsers() {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'get_users_api.php', true);
      xhr.onload = function() {
        const tableBody = document.getElementById('userTable').getElementsByTagName('tbody')[0];
        const errorP = document.getElementById('userLoadingError');
        tableBody.innerHTML = '';
        errorP.style.display = 'none';

        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.error('Error from server:', response.error);
                errorP.textContent = 'Could not load users: ' + response.error;
                errorP.style.display = 'block';
            } else if (response.data && response.data.length > 0) {
                response.data.forEach(user => {
                    const row = tableBody.insertRow();
                    row.insertCell().textContent = user.first_name;
                    row.insertCell().textContent = user.last_name;
                    row.insertCell().textContent = user.email;
                });
            } else {
                const row = tableBody.insertRow();
                const cell = row.insertCell();
                cell.colSpan = 3;
                cell.textContent = 'No users found.';
                cell.style.textAlign = 'center';
            }
          } catch (e) {
            console.error('Error parsing JSON:', e, xhr.responseText);
            errorP.textContent = 'Failed to parse user data.';
            errorP.style.display = 'block';
          }
        } else {
          console.error('Error fetching users:', xhr.statusText);
          errorP.textContent = 'Error fetching users: ' + xhr.statusText;
          errorP.style.display = 'block';
        }
      };
      xhr.onerror = function() {
        console.error('Request to get_users_api.php failed.');
        const errorP = document.getElementById('userLoadingError');
        errorP.textContent = 'Request failed. Please check your connection or if the API endpoint is correct.';
        errorP.style.display = 'block';
      };
      xhr.send();
    }

    getUsers();

    const logoutButton = document.getElementById('logoutBtn');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = this.href;
            }
        });
    }
  </script>
</body>
</html>
