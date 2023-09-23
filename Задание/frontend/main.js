let loginInput = document.getElementById("login");
let passwordInput = document.getElementById("password");
let sendButton = document.getElementById("sendButton");

// Объявляем функцию send
const costil = () => {
    localStorage.clear()
}
const send = () => {
    fetch('http://localhost:8000/api/user/login', {
        method: "POST",
        headers:{
            'Content-Type': "application/json",
        },
        body:JSON.stringify({
            login: loginInput.value,
            password: passwordInput.value
    })
    })
  .then((response) => {
    console.log(response);
    return response.json();

  })
  .then((data) => {
    localStorage.setItem("token", data.token);
    console.log(data)
    document.getElementById("student_link").click();
  });
};

// Добавляем обработчик события на кнопку

costil()
sendButton.addEventListener("click", send);