<?php
session_start();
require_once '../../config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

function fetchTotalVehicles($conn) {
    $sql = "SELECT COUNT(*) AS total_vehicles FROM toll_data";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["total_vehicles"];
    } else {
        return 0;
    }
}

function fetchTotalIncome($conn) {
    $sql = "SELECT SUM(toll_fee) AS total_income FROM toll_data";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["total_income"];
    } else {
        return 0;
    }
}

function fetchOnlineUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

function fetchTollRecords($conn) {
    $sql = "SELECT * FROM toll_data";
    $result = $conn->query($sql);
    $tolls = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tolls[] = $row;
        }
    }

    return $tolls;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="../CSS/admin_control_panel_styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.button-container a');
            const contentContainer = document.getElementById('content-container');

            buttons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    loadContent(button.textContent.trim());
                });
            });

            function loadContent(action) {
                let content = '';

                switch(action) {
                    case 'Collect Toll':
                        content = `
                            <h2 class="title">Toll Controller</h2>
                            <div class="form">
                                <div id="vehicle-selection">
                                <button class="vehicle-btn" onclick="selectVehicle('Motor Cycle', 100)">Motor Cycle</button>
                                <button class="vehicle-btn" onclick="selectVehicle('Car/Jeep', 750)">Car/Jeep </button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Pickup', 1200)">Pickup</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Microbus', 1300)">Microbus</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Medium Bus', 2000)">Medium Bus</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Big Bus', 2400)">Big Bus</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Truck (upto 5 tonnes)', 1600)">Truck (upto 5 tonnes)</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Truck (5-8 tonnes)', 2100)">Truck (5-8 tonnes)</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Truck (3 axle)', 5500)">Truck (3 axle)</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Trailer (4 axle)', 6000)">Trailer (4 axle)</button>
                                    <button class="vehicle-btn" onclick="selectVehicle('Trailer (above 4 axle)', -1)">Trailer (above 4 axle)</button>
                                </div>
                                <div id="payment-section">
                                    <div id="bill-display">
                                        <p id="bill-info"></p>
                                    </div>
                                    <label for="amount">Enter Amount:</label>
                                    <input type="number" id="amount" name="amount" required>
                                    <button onclick="confirmPayment()">Confirm</button>
                                </div>
                            </div>
                        `;
                        break;
                    case 'Total Vehicle':
                        content = `
                            <h2>Total Vehicles</h2>
                            <p>Total Vehicles: <?php echo fetchTotalVehicles($conn); ?></p>
                        `;
                        break;
                    case 'Total Income':
                        content = `
                            <h2>Total Income</h2>
                            <p>Total Income: <?php echo fetchTotalIncome($conn); ?> TK</p>
                        `;
                        break;
                    case 'Database':
                        content = `
                            <h2>Database</h2>
                            <a href="#" class="sub-button" onclick="showOnlineUsers()">Online User Record</a>
                            <a href="#" class="sub-button" onclick="showTollRecords()">Collected Toll Record</a>
                            <a href="#" class="print-button" onclick="printPDF()"><img src="../../Image/print.png" alt="Print"></a>
                            <div id="database-content"></div>
                        `;
                        break;
                    case 'Search':
                        content = `
                            <h2>Search</h2>
                            <button class="sub-button" onclick="searchByLicense()">Search by License Number</button>
                            <button class="sub-button" onclick="searchByDate()">Search by Date</button>
                            <a href="#" class="print-button" onclick="printPDF()"><img src="../../Image/print.png" alt="Print"></a>
                            <div id="search-content"></div>
                        `;
                        break;
                    case 'Back':
                        window.location.href = 'admin_login.php';
                        return;
                    case 'Exit':
                        window.location.href = '../../welcome.html';
                        return;
                    default:
                        content = '<h2>Welcome</h2><p>Please select an option from the menu.</p>';
                        break;
                }

                contentContainer.innerHTML = content;

                // Add the script for toll collection functionality if Collect Toll is selected
                if (action === 'Collect Toll') {
                    addTollCollectionScript();
                }
            }

            function addTollCollectionScript() {
                const script = document.createElement('script');
                script.innerHTML = `
                    function selectVehicle(vehicle, billAmount) {
                        document.getElementById('vehicle-selection').style.display = 'none';
                        document.getElementById('payment-section').style.display = 'block';
                        document.getElementById('amount').focus();

                        let billText;
                        if (billAmount === -1) {
                            let axle = prompt("HOW MANY AXLE:");
                            billAmount = parseInt(axle) * 1500;
                            billText = \`Trailer (above 4 axle)\\nYour Toll Fee: \${billAmount} TK\`;
                        } else {
                            billText = \`Vehicle name: \${vehicle}\\nYour Toll Fee: \${billAmount} TK\`;
                        }

                        document.getElementById('amount').setAttribute('data-bill', billAmount);
                        document.getElementById('bill-info').innerText = billText;
                        document.getElementById('bill-display').style.display = 'block';
                    }

                    function confirmPayment() {
                        var amount = parseInt(document.getElementById('amount').value);
                        var bill = parseInt(document.getElementById('amount').getAttribute('data-bill'));
                        if (amount >= bill) {
                            var refund = amount - bill;
                            if (refund > 0) {
                                alert(\`Payment successful! Driver will get \${refund} TK back.\\nThank You! Have a good Day.:)\nToll data recorded successfully!\`);
                            } else {
                                alert('Payment successful! \\nThank You! Have a good Day.:)');
                            }

                            // Send data to the server to record the toll data
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "record_toll.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.status === "success") {
                                        window.location.href = 'admin_control_panel.php';
                                    } else {
                                        alert('Failed to record toll data.');
                                    }
                                }
                            };
                            xhr.send(\`toll_fee=\${bill}\`);
                        } else {
                            document.getElementById('bill-info').innerText = \`Amount entered is less than the bill. Please enter \${bill} TK for successful completion.\`;
                        }
                    }

                    function showOnlineUsers() {
                        fetch('fetch_online_users.php')
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('database-content').innerHTML = data;
                            })
                            .catch(error => console.error('Error:', error));
                    }

                    function showTollRecords() {
                        fetch('fetch_toll_records.php')
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('database-content').innerHTML = data;
                            })
                            .catch(error => console.error('Error:', error));
                    }

                    function searchByLicense() {
                        const searchContent = document.getElementById('search-content');
                        searchContent.innerHTML = '<input type="text" id="license-number" placeholder="Enter License Number"><button onclick="searchLicense()">Search</button>';
                    }
                    
                    function searchByDate() {
                        const searchContent = document.getElementById('search-content');
                        searchContent.innerHTML = '<input type="date" id="date" placeholder="Enter Date"><button onclick="searchDate()">Search</button>';
                    }
                    
                    function searchLicense() {
                        const licenseNumber = document.getElementById('license-number').value;
                        fetch(\`search_by_license.php?license_number=\${licenseNumber}\`)
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('search-content').innerHTML = data;
                            })
                            .catch(error => console.error('Error:', error));
                    }
                    
                    function searchDate() {
                        const date = document.getElementById('date').value;
                        fetch(\`search_by_date.php?date=\${date}\`)
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('search-content').innerHTML = data;
                            })
                            .catch(error => console.error('Error:', error));
                    }

                    function printPDF() {
                        const { jsPDF } = window.jspdf;
                        const doc = new jsPDF();

                        const content = document.getElementById('database-content') || document.getElementById('search-content') || document.getElementById('content-container');

                        const tableData = [];
                        const rows = content.querySelectorAll('tr');
                        rows.forEach((row) => {
                            const rowData = [];
                            const cells = row.querySelectorAll('th, td');
                            cells.forEach((cell) => {
                                rowData.push(cell.innerText);
                            });
                            tableData.push(rowData);
                        });

                        doc.autoTable({
                            head: [tableData[0]],
                            body: tableData.slice(1),
                            margin: { top: 10, bottom: 20 },
                            didDrawPage: function (data) {
                                doc.setFontSize(10);
                                doc.text(\`Generated: \${new Date().toLocaleString()}\`, data.settings.margin.left, doc.internal.pageSize.height - 10);
                                doc.text('Generated by: Admin panel, Smart Toll System', data.settings.margin.left, doc.internal.pageSize.height - 5);
                            },
                            styles: {
                                fontSize: 10,
                            },
                            theme: 'striped'
                        });

                        doc.save('STS_report.pdf');
                    }
                `;
                document.body.appendChild(script);
            }

            window.printPDF = printPDF;
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="button-container">
            <h3> Admin Control Panel</h3>
            <a href="#">Collect Toll</a>
            <a href="#">Total Vehicle</a>
            <a href="#">Total Income</a>
            <a href="#">Database</a>
            <a href="#">Search</a>
            <a href="admin_login.php" id="back">Back</a>
            <a href="../../welcome.html" id="exit">Exit</a>
        </div>
        <div class="content-container" id="content-container">
            <!-- Dynamic content will be loaded here -->
            <h2>Welcome</h2>
            <p>Please select an option from the menu.</p>
        </div>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System</strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
