document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchResults = document.getElementById('searchResults');

    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const query = document.getElementById('query').value;
        const searchUrl = '/search'; // Asegúrate de que esta URL sea correcta

        fetch(`${searchUrl}?query=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            let html = '<ul class="list-group">';
            
            if (data.results && data.results.length > 0) {
                data.results.forEach(result => {
                    html += `<li class="list-group-item">
                                <a href="orden/{id}/factura">${result.title}</a> (${result.type})
                            </li>`;
                });
            } else {
                html += '<li class="list-group-item">No results found.</li>';
            }
            
            html += '</ul>';
            searchResults.innerHTML = html;
        })
        .catch(error => {
            searchResults.innerHTML = '<p>Error fetching results.</p>';
            console.error('Error:', error);
        });
    });
});
