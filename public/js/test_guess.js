async function makeGuess(pokemonName) {
    const url = 'http://localhost/api/index.php';

    try {
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

async function enviarGuess() {
    const name = document.getElementById('guessInput').value;

    const response = await fetch('/api/index.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ guess: name })
    });

    const data = await response.json();
    console.log("Respuesta del servidor:", data);
}

function renderComparison(comparison) {
    // Así es como usarías los datos para el CSS
    console.log("--- Resultado del Guess ---");

    for (const [key, info] of Object.entries(comparison)) {
        // Ignoramos el valor del nombre para el log de colores
        if (key === 'name') continue;

        let icon = "";
        if (info.result === "correct") icon = "✅";
        else if (info.result === "partial") icon = "🟧";
        else if (info.result === "higher") icon = "⬆️";
        else if (info.result === "lower") icon = "⬇️";
        else icon = "❌";

        console.log(`${key.toUpperCase()}: ${info.value} ${icon}`);
    }
}

// Probar con un pokemon
makeGuess("pikachu");