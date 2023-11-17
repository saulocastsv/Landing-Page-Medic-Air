var freteValor = 0;

function calcularFrete() {

    const currentUrl = (window.location.href).replace("?", "");
    event.preventDefault();

    const cep = (document.getElementById("cepFrete").value).replace("-", '');

    const options = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'User-Agent': 'insomnia/2023.5.8' },
        body: JSON.stringify({ cep: cep, qnt: parseInt(quantidade) })
    };

    fetch(currentUrl + 'api/main.php', options)
        .then(response => response.json())
        .then(data => {
            // Save the response data to a variable or perform actions with the data
            // if (data["valor"] == "Cep Não encotrado.") {
            //     document.getElementById("valorFrete").style.color = "red";
            //     document.getElementById("valorFrete").textContent = "CEP não encontrado.";
            //     document.getElementById("singlebutton-2").disabled = true;
            //     return
            // }
            console.log(data)
            document.getElementById("valorFrete").textContent = data["valor"];
            document.getElementById("prazoFrete").textContent = data["prazo"];
            freteValor = valor
            return
        })
        .catch(err => {
            console.error('Error:', err);
        });
}