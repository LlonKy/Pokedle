async function makeGuess() {
    const url = 'http://localhost/api/index.php';

    
    try {
        const pokemonName = document.getElementById('guessInput').value;
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ guess: pokemonName })
        });

        const data = await response.json();

        if (data.success) {
            renderComparison(data.comparison);
            if (data.is_correct) {
                console.log("¡Felicidades! Es el pokemon correcto.");
            }
        } else {
            console.error("Error:", data.error);
        }
    } catch (error) {
        console.error("Error en la petición:", error);
    }
}


function renderComparison(comparison) {
    console.log("--- Resultado del Guess ---");

    for (const [key, info] of Object.entries(comparison)) {
        if (key === 'name') continue;


        let displayValue = info.value;
        if (info.value === null) {
            displayValue = "None"; 
        }

        let icon = "";
        if (info.result === "correct") icon = "✅";
        else if (info.result === "partial") icon = "🟧";
        else if (info.result === "higher") icon = "⬆️";
        else if (info.result === "lower") icon = "⬇️";
        else icon = "❌";


        console.log(`${key.toUpperCase()}: ${displayValue} ${icon}`);
    }
}
