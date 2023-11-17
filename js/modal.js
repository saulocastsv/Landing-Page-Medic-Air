var quantidade = 0
var valorProduto = 279.00

function modalClick(qnt) {

    $("#myModal").modal('show')
    quantidade = qnt

    if (qnt == 2){
        valorProduto = 259.00
    }
    // alert(event.target.value)
}




