const student_block = document.getElementById("student_info")
const Imya = document.getElementById("Imya");

const infoStudent = () => {
    fetch('http://localhost:8000/api/student/info', {
        method: "get",
        headers:{
            'Content-Type': "application/json",
            'Authorization': 'Bearer '+ localStorage.getItem("token")
        },

    })
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    console.log(data);
    Imya.innerHTML = data.name
  });

}
infoStudent()