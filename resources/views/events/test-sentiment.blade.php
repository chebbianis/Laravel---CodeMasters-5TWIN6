<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Analyse de Sentiment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Analyse de Sentiment</h1>

    <form id="sentiment-form">
        <input type="text" id="text" name="text" placeholder="Tapez un texte en anglais" required>
        <button type="submit">Analyser</button>
    </form>

    <div id="result" style="margin-top:1rem;font-weight:bold;"></div>

    <script>
        const form = document.getElementById('sentiment-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = document.getElementById('text').value;
            const resultDiv = document.getElementById('result');

            resultDiv.textContent = 'Analyse en cours...';
            resultDiv.style.color = 'blue';

            try {
                const response = await fetch('/analyze-sentiment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        text: text
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    resultDiv.textContent = `Résultat : ${data.result} (Score : ${data.score})`;
                    resultDiv.style.color = 'green';
                } else {
                    resultDiv.textContent = 'Erreur : ' + (data.error || 'Unknown error');
                    resultDiv.style.color = 'red';
                    console.error('Error details:', data);
                }
            } catch (err) {
                resultDiv.textContent = 'Erreur réseau : ' + err.message;
                resultDiv.style.color = 'red';
                console.error('Network error:', err);
            }
        });
    </script>
</body>
</html>