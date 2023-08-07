const btnUpdateEmployee = document.querySelectorAll(".updateEmployee")

if (btnUpdateEmployee) {

    btnUpdateEmployee.forEach((employee) => {
        employee.addEventListener("click", function(e) {
    
            const employeeId = e.target.getAttribute("data-id")
            
            fetch("../../../app/employees/findById.php?id=" + employeeId, {
                method: "GET",
                headers: {"Content-Type":"application/json"}
            })
            .then(response => response.json())
            .then(json => {
        
                let name = document.querySelector("div#updateEmployee [name='name']")
                name.value = json.name
        
                let phone = document.querySelector("div#updateEmployee [name='phone']")
                phone.value = json.phone
        
                let username = document.querySelector("div#updateEmployee [name='username']")
                username.value = json.user
        
                let accessLevel = document.querySelector("div#updateEmployee [name='access_level']")
                accessLevel.value = json.access_level
        
                let email = document.querySelector("div#updateEmployee [name='email']")
                email.value = json.email
        
            });
        
            //Modifica a action do form de atualização
            let form = document.querySelector("div#updateEmployee form")
            form.setAttribute("action", "../../../app/employees/update.php?id=" + employeeId)
        
        })
    })
}

const btnUpdateProducts = document.querySelectorAll(".updateProduct")

if (btnUpdateProducts) {

    btnUpdateProducts.forEach((product) => {
        product.addEventListener("click", function(e) {
    
            let productId = e.target.getAttribute("data-id")
            
            fetch("../../../app/products/findById.php?id=" + productId, {
                method: "GET",
                headers: {"Content-Type":"application/json"}
            })
            .then(response => response.json())
            .then(json => {
        
                let name = document.querySelector("div#updateProduct [name='name_product']")
                name.value = json.name
        
                let amount = document.querySelector("div#updateProduct [name='amount']")
                amount.value = parseInt(json.amount)
        
                let price = document.querySelector("div#updateProduct [name='price']")
                price.value = json.value
        
                let type_product = document.querySelector("div#updateProduct [name='type_product']")
                type_product.value = json.unit_type
        
            })
        
            //Modifica a action do form de atualização
            let form = document.querySelector("div#updateProduct form")
            form.setAttribute("action", "../../../app/products/update.php?id=" + productId)
        
        })
    })
}