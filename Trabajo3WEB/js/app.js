"use strict"

console.log("TOLARDO")
const BASE_URL ='http://localhost/WEB2/todoListRest/api/';
let form = document.querySelector("#task-form");
form.addEventListener('submit', insertTask)
// creo el arreglo que le voy a almacenar las tareas
let tasks=[];
// obtiene las tareas de la api rest
// arreglo de tareas
async function getAll() {
    try{
        const response = await fetch(BASE_URL+'tareas');
        
        if(!response.ok){
            throw new Error('Error al llamar tareas');
        }
        
        tasks = await response.json();
        showTasks();
    }catch(error){
        console.log(error)
    }
  
}

async function insertTask(e){
    e.preventDefault();

    let data = new FormData(form);
    let task = {
        titulo: data.get('titulo'),
        descripcion: data.get('descripcion'),
        prioridad: data.get('prioridad'),
        finalizada : 0
    };

    try {
        let response = await fetch(BASE_URL+ "tareas", {
            method: "POST",
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(task)
        });
        if (!response.ok) {
            throw new Error('Error del servidor');
        }

        let nTask = await response.json();

        // inserto la tarea nueva
        tasks.push(nTask);
        showTasks();

        form.reset();
    } catch(error) {
        console.log(error);
    }

}


// renderiza lista de tareas
function showTasks(){
   console.log("Entro")
    // agarro del htlm el ul
    let ul = document.querySelector("#task-list");
    // vacio el ul por si tiene algo
    ul.innerHTML= " ";

    for(const task of tasks){
        // creo un html ( CADA <LI> )
        let html = `
            <li class='
                    list-group-item d-flex justify-content-between align-items-center
                    ${ task.finalizada == 1 ? 'finalizada' : ''}
                '>
                <span> <b>${task.titulo}</b> - ${task.descripcion} (prioridad ${task.prioridad}) </span>
                <div class="ml-auto">
                    ${task.finalizada != 1 ? `<a href='#' data-task="${task.id}" type='button' class='btn btn-small btn-success btn-finalize'>Finalizar</a>` : ''}
                    <a href='#' data-task="${task.id}" type='button' class='btn btn-small btn-danger btn-delete'>Borrar</a>
                </div>
            </li>
        `;

        // SE LOS VOY INSERTANDO MEDIANTE RECORRE EL FOR AL UL QUE TRAJE DEL HTML
        ul.innerHTML += html;

    }
}

getAll();