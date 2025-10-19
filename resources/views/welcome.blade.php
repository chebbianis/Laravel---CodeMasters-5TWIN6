<!DOCTYPE html>
<html>
<head>
    <title>Test Sentiment Analysis</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test d'analyse de sentiment</h1>
    
    <form id="sentimentForm">
        @csrf
        <textarea name="text" id="text" rows="4" cols="50" placeholder="Entrez votre texte ici..."></textarea>
        <br><br>
        <button type="submit">Analyser le sentiment</button>
    </form>
    
    <div id="result" style="margin-top: 20px;"></div>

    <script>
        document.getElementById('sentimentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('text', document.getElementById('text').value);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/analyze-sentiment', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('result').innerHTML = 
                        '<p style="color: red;">Erreur: ' + data.error + '</p>';
                } else {
                    document.getElementById('result').innerHTML = 
                        '<p>Résultat: <strong>' + data.result + '</strong></p>' +
                        '<p>Score: ' + data.score + '</p>';
                }
            })
            .catch(error => {
                document.getElementById('result').innerHTML = 
                    '<p style="color: red;">Erreur: ' + error + '</p>';
            });
        });
    </script>
</body>
</html>