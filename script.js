async function carregarLista() {
    const response = await fetch("fetch.php");
    const lista = await response.json();

    const select = document.getElementById("morse");

    lista.forEach(item => {
        const option = document.createElement("option");
        option.value = item;   // você pode colocar o ID aqui se quiser
        option.textContent = item;
        select.appendChild(option);
    });
}

carregarLista();