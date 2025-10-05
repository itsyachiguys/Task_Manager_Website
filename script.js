// DOM element selection - get references to form inputs and UI elements
const taskForm = document.getElementById("taskForm");
const taskInput = document.getElementById("taskInput");
const taskList = document.getElementById("taskList");

// task data management - load tasks from localStorage with fallback to empty array
let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

// task rendering function - creates and displays task items with complete/delete buttons
function renderTasks() {
  taskList.innerHTML = "";
  tasks.forEach((task, index) => {
    const taskDiv = document.createElement("div");
    taskDiv.className = "task " + (task.completed ? "completed" : "");
    taskDiv.innerHTML = `
      <span>${task.text}</span>
      <div>
        <button onclick="toggleTask(${index})" style="background:#2a9d8f;color:#fff;">✔</button>
        <button onclick="deleteTask(${index})" style="background:#e63946;color:#fff;">🗑️</button>
      </div>
    `;
    taskList.appendChild(taskDiv);
  });
  localStorage.setItem("tasks", JSON.stringify(tasks));
}

// form submission handler - add new task to list and update UI
taskForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const taskText = taskInput.value.trim();
  if (taskText === "") return;
  tasks.push({ text: taskText, completed: false });
  taskInput.value = "";
  renderTasks();
});

// task completion toggle - mark task as complete/incomplete and re-render
function toggleTask(index) {
  tasks[index].completed = !tasks[index].completed;
  renderTasks();
}

// task deletion function - remove task from array and update storage/UI
function deleteTask(index) {
  tasks.splice(index, 1);
  renderTasks();
}

// dark mode toggle function - switch between light and dark themes
function toggleDarkMode() {
  document.body.classList.toggle("dark-mode");
  if (document.body.classList.contains("dark-mode")) {
    localStorage.setItem("darkMode", "enabled");
  } else {
    localStorage.setItem("darkMode", "disabled");
  }
}

// page initialization - restore dark mode preference and render tasks on load
window.onload = () => {
  if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
  }
  renderTasks();
};
