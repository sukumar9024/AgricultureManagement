<?php
session_start();

// Check if the user clicked the logout button
if(isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: ../login.html");
    exit;
}

// Check if the user is logged in
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // Redirect back to login page if not logged in
    header("Location: ../login.html");
    exit;
}

// Check if username is set in session
if(isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    // If username is not set, redirect to login page
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grabit - Purchase</title>
    <link rel="stylesheet" href="all_items.css">
</head>
<body>
   <nav>
         <div class="nav__content">
            <div class="logo"><a href="#">Grabit</a></div>
            <label for="check" class="checkbox">
               <i class="ri-menu-line"></i>
            </label>
            <input type="checkbox" name="check" id="check" />
            <ul style="display: flex; align-items: center; gap: 1rem; list-style: none; transition: left 0.3s;">
               <li><a href="index.html">Home</a></li>
               <li><a href="login.html">Login</a></li>
               <li><a href="../cart.php">Cart</a></li>
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <button type="submit" name="logout" style="color:red;">Logout</button>
               </form>

            </ul>
         </div>
   </nav>
   <!-- NAVIGATION-BAR / TOOL-BAR -->
    <div class="tool-bar">
        <!-- Your existing code for the toolbar -->
    </div>

   <!-- HEADING -->
    <div class="centered-heading">
      <h1>Grabit</h1>
  </div>

  <!-- 3 BOXES(2 SELECTION BOXES, 1 SEARCH BUTTON BOX) -->
  <div class="boxes-container">
      <!-- FIRST BOX (STATES BOX) -->
      <div class="box">
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="searchForm">
            <label for="state">Select State:</label>
            <select id="state" name="state">
               <!-- Options for states -->
               <option value="select_state">Select State</option>
               <option value="andaman_and_nicobar">Andaman and Nicobar Islands</option>
               <option value="Andhra Pradesh">Andhra Pradesh</option>
               <option value="arunachal_pradesh">Arunachal Pradesh</option>
               <option value="assam">Assam</option>
               <option value="bihar">Bihar</option>
               <option value="chandigarh">Chandigarh</option>
               <option value="chhattisgarh">Chhattisgarh</option>
               <option value="dadra_and_nagar_haveli">Dadra and Nagar Haveli</option>
               <option value="daman_and_diu">Daman and Diu</option>
               <option value="delhi">Delhi</option>
               <option value="goa">Goa</option>
               <option value="gujarat">Gujarat</option>
               <option value="haryana">Haryana</option>
               <option value="himachal_pradesh">Himachal Pradesh</option>
               <option value="jammu_and_kashmir">Jammu and Kashmir</option>
               <option value="jharkhand">Jharkhand</option>
               <option value="karnataka">Karnataka</option>
               <option value="kerala">Kerala</option>
               <option value="lakshadweep">Lakshadweep</option>
               <option value="madhya_pradesh">Madhya Pradesh</option>
               <option value="maharashtra">Maharashtra</option>
               <option value="manipur">Manipur</option>
               <option value="meghalaya">Meghalaya</option>
               <option value="mizoram">Mizoram</option>
               <option value="nagaland">Nagaland</option>
               <option value="odisha">Odisha</option>
               <option value="puducherry">Puducherry</option>
               <option value="punjab">Punjab</option>
               <option value="rajasthan">Rajasthan</option>
               <option value="sikkim">Sikkim</option>
               <option value="tamil_nadu">Tamil Nadu</option>
               <option value="telangana">Telangana</option>
               <option value="tripura">Tripura</option>
               <option value="uttar_pradesh">Uttar Pradesh</option>
               <option value="uttarakhand">Uttarakhand</option>
               <option value="west_bengal">West Bengal</option>
            </select>
         </div>
         <!-- SECOND BOX (DISTRICTS BOX) -->
         <div class="box">
            <label for="city">Select City:</label>
            <select id="city" name="city">
               <!-- Options for cities go here -->
               <!-- This part will be dynamically populated using JavaScript -->
            </select>
         </div>
         <!-- THIRD BOX (SEARCH BUTTON BOX) -->
      </div>
      <div class="search-box">
         <input type="submit" id="submitButton" style=" padding: 10px; border-radius: 15px;">
      </div>
   </form>

    <!-- Add an empty container for displaying the fetched data -->
    <div id="dataContainer">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // Retrieve the selected state and city
         $selectedState = $_POST["state"];
         $selectedCity = $_POST["city"];

         // Establish a connection to the database
         $servername = "localhost"; // Change this if your database is hosted elsewhere
         $username = "root";
         $password = "";
         $dbname = "agriculture_management";
         $conn = new mysqli($servername, $username, $password, $dbname);

         // Check the connection
         if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
         }

         // Prepare and execute the SQL query to fetch product data based on the selected state and city
         $sql = "SELECT * FROM product WHERE state = '$selectedState' AND city = '$selectedCity'";
         $result = $conn->query($sql);
         
          // Display the fetched product data
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo "<img src='" . $row["image_link"] . "' alt='" . (isset($row["name"]) ? $row["name"] : "") . "' class='product-image'>";
                echo "<div class='product-details'>";
                echo "<p class='seller-name'>" . $row["seller"] . "</p>";
                echo "<p class='rating'>Rating: " . $row["rating"] . "</p>";
                echo "<p class='price'>Price: $" . $row["price"] . "</p>";
                 // Modify the button to include the productId as a data attribute
                echo "<button class='add-to-cart' data-productId='" . $row["id"] . "'>Add to Cart</button>";
                echo "</div>"; // Close product-details
                echo "</div>"; // Close product-card
            }
         } else {
            echo "No products found.";
         }

         // Close the database connection
         $conn->close();
      }
      ?>
   </div>


   <script>
      // Get references to the state and city dropdowns
      var stateDropdown = document.getElementById('state');
      var cityDropdown = document.getElementById('city');

      // Define a mapping of states to corresponding cities
      var citiesByState = {
         'select_state': ['Select City'],
         'andaman_and_nicobar': ['South Andaman', 'North and Middle Andaman', 'Nicobar'],
         'Andhra Pradesh': ['Anantapur', 'Chittoor', 'East Godavari', 'Guntur', 'Krishna', 'Kurnool', 'Nellore', 'Prakasam', 'Srikakulam', 'Visakhapatnam', 'Vizianagaram', 'West Godavari', 'YSR Kadapa'],
         'arunachal_pradesh' : ['Anjaw', 'Central Siang', 'Changlang', 'Dibang Valley', 'East Kameng', 'East Siang', 'Kamle', 'Kra Daadi', 'Kurung Kumey', 'Lepa Rada', 'Lohit', 'Longding', 'Lower Dibang Valley', 'Lower Siang', 'Lower Subansiri', 'Namsai', 'Pakke Kessang', 'Papum Pare', 'Shi Yomi', 'Tawang', 'Tirap', 'Upper Siang', 'Upper Subansiri', 'West Kameng', 'West Siang'],
         'assam' : ['Baksa', 'Barpeta', 'Bongaigaon', 'Cachar', 'Charaideo', 'Chirang', 'Darrang', 'Dhemaji', 'Dhubri', 'Dibrugarh', 'Dima Hasao', 'Goalpara', 'Golaghat', 'Hailakandi', 'Jorhat', 'Kamrup', 'Kamrup Metropolitan', 'Karbi Anglong', 'Karimganj', 'Kokrajhar', 'Lakhimpur', 'Majuli', 'Morigaon', 'Nagaon', 'Nalbari', 'Sivasagar', 'Sonitpur', 'South Salmara-Mankachar', 'Tinsukia', 'Udalguri', 'West Karbi Anglong'],
         'bihar' : ['Araria', 'Arwal', 'Aurangabad', 'Banka', 'Begusarai', 'Bhagalpur', 'Bhojpur', 'Buxar', 'Darbhanga', 'East Champaran', 'Gaya', 'Gopalganj', 'Jamui', 'Jehanabad', 'Kaimur', 'Katihar', 'Khagaria', 'Kishanganj', 'Lakhisarai', 'Madhepura', 'Madhubani', 'Munger', 'Muzaffarpur', 'Nalanda', 'Nawada', 'Patna', 'Purnia', 'Rohtas', 'Saharsa', 'Samastipur', 'Saran', 'Sheikhpura', 'Sheohar', 'Sitamarhi', 'Siwan', 'Supaul', 'Vaishali', 'West Champaran'],
         'chandigarh': ['Chandigarh'],
         'chhattisgarh' : ['Balod', 'Baloda Bazar', 'Balrampur', 'Bastar', 'Bemetara', 'Bijapur', 'Bilaspur', 'Dantewada', 'Dhamtari', 'Durg', 'Gariaband', 'Gaurela Pendra Marwahi', 'Janjgir Champa', 'Jashpur', 'Kabirdham', 'Kanker', 'Khairagarh', 'Kondagaon', 'Korba', 'Koriya', 'Mahasamund', 'Manendragarh', 'Mohla Manpur', 'Mungeli', 'Narayanpur', 'Raigarh', 'Raipur', 'Rajnandgaon', 'Sakti', 'Sarangarh Bilaigarh', 'Sukma', 'Surajpur', 'Surguja'],
         'dadra_and_nagar_haveli' : ['Dadra and Nagar Haveli'],
         'daman_and_diu' : ['Daman', 'Diu'],
         'delhi' : ['Central Delhi', 'East Delhi', 'New Delhi', 'North Delhi', 'North East Delhi', 'North West Delhi', 'Shahdara', 'South Delhi', 'South East Delhi', 'South West Delhi', 'West Delhi'],
         'goa' : ['North Goa', 'South Goa'],
         'gujarat' : ['Ahmedabad', 'Amreli', 'Anand', 'Aravalli', 'Banaskantha', 'Bharuch', 'Bhavnagar', 'Botad', 'Chhota Udaipur', 'Dahod', 'Dang', 'Devbhoomi Dwarka', 'Gandhinagar', 'Gir Somnath', 'Jamnagar', 'Junagadh', 'Kheda', 'Kutch', 'Mahisagar', 'Mehsana', 'Morbi', 'Narmada', 'Navsari', 'Panchmahal', 'Patan', 'Porbandar', 'Rajkot', 'Sabarkantha', 'Surat', 'Surendranagar', 'Tapi', 'Vadodara', 'Valsad'],
         'haryana' : ['Ambala', 'Bhiwani', 'Charkhi Dadri', 'Faridabad', 'Fatehabad', 'Gurugram', 'Hisar', 'Jhajjar', 'Jind', 'Kaithal', 'Karnal', 'Kurukshetra', 'Mahendragarh', 'Mewat', 'Palwal', 'Panchkula', 'Panipat', 'Rewari', 'Rohtak', 'Sirsa', 'Sonipat', 'Yamunanagar'],
         'himachal_pradesh' : ['Bilaspur', 'Chamba', 'Hamirpur', 'Kangra', 'Kinnaur', 'Kullu', 'Lahaul Spiti', 'Mandi', 'Shimla', 'Sirmaur', 'Solan', 'Una'],
         'jammu_and_kashmir': ['Anantnag', 'Bandipora', 'Baramulla', 'Budgam', 'Doda', 'Ganderbal', 'Jammu', 'Kathua', 'Kishtwar', 'Kulgam', 'Kupwara', 'Poonch', 'Pulwama', 'Rajouri', 'Ramban', 'Reasi', 'Samba', 'Shopian', 'Srinagar', 'Udhampur'],
         'jharkhand': ['Bokaro', 'Chatra', 'Deoghar', 'Dhanbad', 'Dumka', 'East Singhbhum', 'Garhwa', 'Giridih', 'Godda', 'Gumla', 'Hazaribagh', 'Jamtara', 'Khunti', 'Koderma', 'Latehar', 'Lohardaga', 'Pakur', 'Palamu', 'Ramgarh', 'Ranchi', 'Sahebganj', 'Seraikela Kharsawan', 'Simdega', 'West Singhbhum'],
         'karnataka' : ['Bagalkot', 'Bangalore Rural', 'Bangalore Urban', 'Belgaum', 'Bellary', 'Bidar', 'Chamarajanagar', 'Chikkaballapur', 'Chikkamagaluru', 'Chitradurga', 'Dakshina Kannada', 'Davanagere', 'Dharwad', 'Gadag', 'Gulbarga', 'Hassan', 'Haveri', 'Kodagu', 'Kolar', 'Koppal', 'Mandya', 'Mysore', 'Raichur', 'Ramanagara', 'Shimoga', 'Tumkur', 'Udupi', 'Uttara Kannada', 'Vijayanagara', 'Vijayapura ', 'Yadgir'],
         'kerala' : ['Alappuzha', 'Ernakulam', 'Idukki', 'Kannur', 'Kasaragod', 'Kollam', 'Kottayam', 'Kozhikode', 'Malappuram', 'Palakkad', 'Pathanamthitta', 'Thiruvananthapuram', 'Thrissur', 'Wayanad'],
         'ladakh' : ['Kargil', 'Leh'],
         'lakshadweep' : ['Lakshadweep'],
         'madhya_pradesh' : ['Agar Malwa', 'Alirajpur', 'Anuppur', 'Ashoknagar', 'Balaghat', 'Barwani', 'Betul', 'Bhind', 'Bhopal', 'Burhanpur', 'Chachaura', 'Chhatarpur', 'Chhindwara', 'Damoh', 'Datia', 'Dewas', 'Dhar', 'Dindori', 'Guna', 'Gwalior', 'Harda', 'Hoshangabad', 'Indore', 'Jabalpur', 'Jhabua', 'Katni', 'Khandwa', 'Khargone', 'Maihar', 'Mandla', 'Mandsaur', 'Morena', 'Nagda', 'Narsinghpur', 'Neemuch', 'Niwari', 'Pandhurna', 'Panna', 'Raisen', 'Rajgarh', 'Ratlam', 'Rewa', 'Sagar', 'Satna', 'Sehore', 'Seoni', 'Shahdol', 'Shajapur', 'Sheopur', 'Shivpuri', 'Sidhi', 'Singrauli', 'Tikamgarh', 'Ujjain', 'Umaria', 'Vidisha'],
         'maharashtra':['Ahmednagar', 'Akola', 'Amravati', 'Aurangabad', 'Beed', 'Bhandara', 'Buldhana', 'Chandrapur', 'Dhule', 'Gadchiroli', 'Gondia', 'Hingoli', 'Jalgaon', 'Jalna', 'Kolhapur', 'Latur', 'Mumbai City', 'Mumbai Suburban', 'Nagpur', 'Nanded', 'Nandurbar', 'Nashik', 'Osmanabad', 'Palghar', 'Parbhani', 'Pune', 'Raigad', 'Ratnagiri', 'Sangli', 'Satara', 'Sindhudurg', 'Solapur', 'Thane', 'Wardha', 'Washim', 'Yavatmal'],
         'manipur':['Bishnupur', 'Chandel', 'Churachandpur', 'Imphal East', 'Imphal West', 'Jiribam', 'Kakching', 'Kamjong', 'Kangpokpi', 'Noney', 'Pherzawl', 'Senapati', 'Tamenglong', 'Tengnoupal', 'Thoubal', 'Ukhrul'],
         'meghalaya':['East Garo Hills', 'East Jaintia Hills', 'East Khasi Hills', 'Mairang', 'North Garo Hills', 'Ri Bhoi', 'South Garo Hills', 'South West Garo Hills', 'South West Khasi Hills', 'West Garo Hills', 'West Jaintia Hills', 'West Khasi Hills'],
         'mizoram':['Aizawl', 'Champhai', 'Hnahthial', 'Kolasib', 'Khawzawl', 'Lawngtlai', 'Lunglei', 'Mamit', 'Saiha', 'Serchhip', 'Saitual'],
         'Nagaland':['Chumukedima', 'Dimapur', 'Kiphire', 'Kohima', 'Longleng', 'Mokokchung', 'Mon', 'Niuland', 'Noklak', 'Peren', 'Phek', 'Shamator', 'Tseminyu', 'Tuensang', 'Wokha', 'Zunheboto'],
         'odisha':['Angul', 'Balangir', 'Balasore', 'Bargarh', 'Bhadrak', 'Boudh', 'Cuttack', 'Debagarh', 'Dhenkanal', 'Gajapati', 'Ganjam', 'Jagatsinghpur', 'Jajpur', 'Jharsuguda', 'Kalahandi', 'Kandhamal', 'Kendrapara', 'Kendujhar', 'Khordha', 'Koraput', 'Malkangiri', 'Mayurbhanj', 'Nabarangpur', 'Nayagarh', 'Nuapada', 'Puri', 'Rayagada', 'Sambalpur', 'Subarnapur', 'Sundergarh'],
         'puducherry' : ['Karaikal', 'Mahe', 'Puducherry', 'Yanam'],
         'punjab':['Amritsar', 'Barnala', 'Bathinda', 'Faridkot', 'Fatehgarh Sahib', 'Fazilka', 'Firozpur', 'Gurdaspur', 'Hoshiarpur', 'Jalandhar', 'Kapurthala', 'Ludhiana', 'Malerkotla', 'Mansa', 'Moga', 'Mohali', 'Muktsar', 'Pathankot', 'Patiala', 'Rupnagar', 'Sangrur', 'Shaheed Bhagat Singh Nagar', 'Tarn Taran'],
         'rajasthan':['Ajmer', 'Alwar', 'Anupgarh', 'Balotra', 'Banswara', 'Baran', 'Barmer', 'Beawar', 'Bharatpur', 'Bhilwara', 'Bikaner', 'Bundi', 'Chittorgarh', 'Churu', 'Dausa', 'Deeg', 'Dholpur', 'Didwana-Kuchaman', 'Dudu', 'Dungarpur', 'Gangapur City', 'Hanumangarh', 'Jaipur', 'Jaipur Rural', 'Jaisalmer', 'Jalore', 'Jhalawar', 'Jhunjhunu', 'Jodhpur', 'Jodhpur Rural', 'Karauli', 'Kekri', 'Khairthal–Tijara', 'Kota', 'Kotputli-Behror', 'Nagaur', 'Neem ka Thana', 'Pali', 'Phalodi', 'Pratapgarh', 'Rajsamand', 'Salumbar', 'Sanchore', 'Sawai Madhopur', 'Shahpura', 'Sikar', 'Sirohi', 'Sri Ganganagar', 'Tonk', 'Udaipur'],
         'sikkim':['East Sikkim', 'North Sikkim', 'Pakyong', 'Soreng', 'South Sikkim', 'West Sikkim'],
         'tamil_nadu':['Ariyalur', 'Chengalpattu', 'Chennai', 'Coimbatore', 'Cuddalore', 'Dharmapuri', 'Dindigul', 'Erode', 'Kallakurichi', 'Kanchipuram', 'Kanyakumari', 'Karur', 'Krishnagiri', 'Madurai', 'Mayiladuthurai ', 'Nagapattinam', 'Namakkal', 'Nilgiris', 'Perambalur', 'Pudukkottai', 'Ramanathapuram', 'Ranipet', 'Salem', 'Sivaganga', 'Tenkasi', 'Thanjavur', 'Theni', 'Thoothukudi', 'Tiruchirappalli', 'Tirunelveli', 'Tirupattur', 'Tiruppur', 'Tiruvallur', 'Tiruvannamalai', 'Tiruvarur', 'Vellore', 'Viluppuram', 'Virudhunagar'],
         'telangana':['Adilabad', 'Bhadradri Kothagudem', 'Hyderabad', 'Jagtial', 'Jangaon', 'Jayashankar', 'Jogulamba', 'Kamareddy', 'Karimnagar', 'Khammam', 'Komaram Bheem', 'Mahabubabad', 'Mahbubnagar', 'Mancherial', 'Medak', 'Medchal', 'Mulugu', 'Nagarkurnool', 'Nalgonda', 'Narayanpet', 'Nirmal', 'Nizamabad', 'Peddapalli', 'Rajanna Sircilla', 'Ranga Reddy', 'Sangareddy', 'Siddipet', 'Suryapet', 'Vikarabad', 'Wanaparthy', 'Warangal', 'Hanamkonda', 'Yadadri Bhuvanagiri'],
         'tripura':['Dhalai', 'Gomati', 'Khowai', 'North Tripura', 'Sepahijala', 'South Tripura', 'Unakoti', 'West Tripura'],
         'uttar_pradesh':['Agra', 'Aligarh', 'Ambedkar Nagar', 'Amethi', 'Amroha', 'Auraiya', 'Ayodhya', 'Azamgarh', 'Baghpat', 'Bahraich', 'Ballia', 'Balrampur', 'Banda', 'Barabanki', 'Bareilly', 'Basti', 'Bhadohi', 'Bijnor', 'Budaun', 'Bulandshahr', 'Chandauli', 'Chitrakoot', 'Deoria', 'Etah', 'Etawah', 'Farrukhabad', 'Fatehpur', 'Firozabad', 'Gautam Buddha Nagar', 'Ghaziabad', 'Ghazipur', 'Gonda', 'Gorakhpur', 'Hamirpur', 'Hapur', 'Hardoi', 'Hathras', 'Jalaun', 'Jaunpur', 'Jhansi', 'Kannauj', 'Kanpur Dehat', 'Kanpur Nagar', 'Kasganj', 'Kaushambi', 'Kheri', 'Kushinagar', 'Lalitpur', 'Lucknow', 'Maharajganj', 'Mahoba', 'Mainpuri', 'Mathura', 'Mau', 'Meerut', 'Mirzapur', 'Moradabad', 'Muzaffarnagar', 'Pilibhit', 'Pratapgarh', 'Prayagraj', 'Raebareli', 'Rampur', 'Saharanpur', 'Sambhal', 'Sant Kabir Nagar', 'Shahjahanpur', 'Shamli', 'Shravasti', 'Siddharthnagar', 'Sitapur', 'Sonbhadra', 'Sultanpur', 'Unnao', 'Varanasi'],
         'uttarakhand': ['Almora', 'Bageshwar', 'Chamoli', 'Champawat', 'Dehradun', 'Haridwar', 'Nainital', 'Pauri', 'Pithoragarh', 'Rudraprayag', 'Tehri', 'Udham Singh Nagar', 'Uttarkashi'],
         'west_engal':['Alipurduar', 'Bankura', 'Birbhum', 'Cooch Behar', 'Dakshin Dinajpur', 'Darjeeling', 'Hooghly', 'Howrah', 'Jalpaiguri', 'Jhargram', 'Kalimpong', 'Kolkata', 'Malda', 'Murshidabad', 'Nadia', 'North 24 Parganas', 'Paschim Bardhaman', 'Paschim Medinipur', 'Purba Bardhaman', 'Purba Medinipur', 'Purulia', 'South 24 Parganas', 'Uttar Dinajpur']
      };

      // Function to update city dropdown based on selected state
      function updateCities() {
         // Clear existing options
         cityDropdown.innerHTML = '';

         // Get the selected state
         var selectedState = stateDropdown.value;

         // Get the corresponding cities for the selected state
         var cities = citiesByState[selectedState] || [];

         // Populate the city dropdown with options
         cities.forEach(function(city) {
            var option = document.createElement('option');
            option.value = city;
            option.text = city;
            cityDropdown.add(option);
         });
      }

      // Attach the updateCities function to the change event of the state dropdown
      stateDropdown.addEventListener('change', updateCities);

      // Initial population of the city dropdown based on the default selected state
      updateCities();

   </script>

   <script src="add_to_cart.js"></script>
</body>
</html>
