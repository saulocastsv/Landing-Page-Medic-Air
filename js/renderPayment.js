
const mp = new MercadoPago(
    "APP_USR-64796ac1-be0e-4f6e-a4f6-d24347dff9e0",
    {
        locale: "pt-BR",
    }
);

const bricksBuilder = mp.bricks();

const renderPaymentBrick = async (bricksBuilder) => {

    var frete = document.getElementById("valorFrete").textContent.split(' ')[1]
    const currentUrl = (window.location.href);
    const settings = {
        initialization: {
            amount: (valorProduto * quantidade) + freteValor, //
            preferenceId: "<PREFERENCE_ID>",
        },
        customization: {
            paymentMethods: {
                ticket: "all",
                bankTransfer: "all",
                creditCard: "all",
                debitCard: "all",
                mercadoPago: "all",
            },
        },
        callbacks: {
            onReady: () => {

            },
            onSubmit: ({ selectedPaymentMethod, formData }) => {
                return new Promise((resolve, reject) => {
                    fetch(currentUrl + "./process_payment/payment.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(formData),
                    })
                        .then((response) => response.json())
                        .then((response) => {
                            if (formData.payment_method_id == "pix") {
                                var pix_qr = document.getElementById("copiaCola");
                                var qr_code_img = document.getElementById("imgModal");
                                const collection = document.getElementsByClassName("svelte-1a8kh4a");

                                for (let i = 0; i < collection.length; i++) {
                                    collection[i].classList.remove("loading-3ceazC");
                                }

                                pix_qr.innerText = response.qr_code;
                                qr_code_img.src = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" + response.qr_code;

                                var myModal = new bootstrap.Modal(document.getElementById('pixModal'), {
                                    keyboard: false
                                })

                                myModal.show()

                                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                                    keyboard: false
                                })

                                myModal.show()

                            }
                            else {
                                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                                    keyboard: false
                                })

                                myModal.show()
                            }


                        }).catch((error) => {
                            console.log('Response:', error);
                        });
                });
            },
            onError: (error) => {
                console.error(error);
            },
        },
    };
    window.paymentBrickController = await bricksBuilder.create(
        "payment",
        "paymentBrick_container",
        settings
    );
};

