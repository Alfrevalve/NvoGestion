import './bootstrap';
import axios from 'axios';

// Example function to fetch data from an API
async function fetchData() {
    try {
        const response = await axios.get('/api/endpoint'); // Replace with your actual API endpoint
        console.log(response.data);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

// Example function to handle a button click
document.getElementById('myButton').addEventListener('click', () => {
    fetchData();
});
