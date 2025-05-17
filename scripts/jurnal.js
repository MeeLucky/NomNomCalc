refresAll();


function refresAll() {
    let response = ajaxSend("php/getJurnal.php", new Map(), "GET", (response) => {
        console.log(response);
    }); 
}

function createNewDay() {
    
}