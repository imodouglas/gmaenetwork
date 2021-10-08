const payment = {
    confirm(id){
        let inv = 'current-investment='+id+'&cmd=confirm';
        $.post('api.php', inv, (result)=>{
            if(result == true){
                location.reload();
            } else {
                alert("An error occured!");
            }
        });
    }, 
    
    card(id, amount, email, name) {
        FlutterwaveCheckout({
            public_key: "FLWPUBK-c6d1febc7d481ccff2a866034adde047-X",
            tx_ref: "RX1",
            amount: amount,
            currency: "NGN",
            country: "NG",
            payment_options: " ",
            customer: {
                email: email,
                name: name,
            },
            callback: function (data) { // specified callback function
                console.log(data);
                if(data.status == 'successful'){
                    let inv = 'current-investment='+id+'&cmd=confirm';
                    $.post('api.php', inv, (result)=>{
                        if(result == true){
                            location.reload();
                        } else {
                            alert("An error occured!");
                        }
                    });
                }
            },
            customizations: {
                title: "GMAE Network",
                description: "Payment for investment",
                logo: "https://gmaenetwork.com/wp-content/uploads/2021/08/lo-278x300.png",
            },
        });
    }
}

const investment = {
    confirm(id) {
        let inv = 'current-investment='+id+'&cmd=confirm';
        $.post('api.php', inv, (result)=>{
            if(result == true){
                location.reload();
            } else {
                alert("An error occured!");
            }
        });
    }, 

    activate(id) {
        let data = 'investment='+id+'&cmd=data';
        $.post('api.php', data, function(result){
            if(result !== false){
                payment(id, result.plan.amount, result.user.email, result.user.first_name+" "+result.user.last_name)
                // console.log(result);
            }
        });
    },

    delete(id){
        let data = 'investment='+id+'&cmd=delete';
        if(confirm('Are you sure you want to cancel this plan?')){
            $.post('api.php', data, function(result){
                if(result !== false){
                    location.reload();
                } else {
                    alert('An error occured! Please try again.');
                }
            });
        }
    },

    complete(id){
        let data = 'investment='+id+'&cmd=complete';
        $.post('api.php', data, function(result){
            if(result !== false){
                location.reload();
            } else {
                alert('An error occured! Please try again.');
            }
        });
    },
}