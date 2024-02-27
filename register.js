document.getElementById('registrationForm').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Get form data
    const formData = new FormData(this);

    // Send form data to server using Fetch API
    try {
        const response = await fetch('/register', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            // Registration successful
            console.log('Registration successful');
            // Redirect to a new page or display a success message
        } else {
            // Registration failed
            const errorMessage = await response.text();
            console.error('Registration failed:', errorMessage);
            // Display error message to the user
        }
    } catch (error) {
        console.error('Error:', error);
        // Display error message to the user
    }
});
