
/* shared app logic for the frontend-only task manager */

// storage keys - constants for localstorage data persistence
const KEY_TASKS = "tm_tasks_v1";
const KEY_PROJECTS = "tm_projects_v1";
const KEY_GRADES = "tm_grades_v1";

// load/save helpers - task management functions for localstorage operations
function loadTasks(){
  // load tasks from localStorage or fallback to tasks.json if localStorage is empty
  let tasks = JSON.parse(localStorage.getItem(KEY_TASKS) || "[]");
  if(tasks.length === 0){
    // fetch tasks from tasks.json file
    fetch('tasks.json')
      .then(response => response.json())
      .then(data => {
        localStorage.setItem(KEY_TASKS, JSON.stringify(data));
        tasks = data;
        // re-render if on home page
        if(document.getElementById('upcoming')) renderUpcoming();
        if(document.getElementById('alertsArea')) renderAlerts();
      })
      .catch(err => console.error('Error loading tasks.json:', err));
  }
  return tasks;
}
function saveTasks(tasks){
  localStorage.setItem(KEY_TASKS, JSON.stringify(tasks));
}
function addTask(task){
  const tasks = loadTasks();
  tasks.push(task);
  saveTasks(tasks);
}
function updateTask(index, task){
  const tasks = loadTasks();
  tasks[index] = task;
  saveTasks(tasks);
}
function removeTask(index){
  const tasks = loadTasks();
  tasks.splice(index,1);
  saveTasks(tasks);
}

// utility: days between - calculates days between a given date and today
function daysBetween(dateStr){
  const d = new Date(dateStr);
  const today = new Date(); today.setHours(0,0,0,0);
  const diff = Math.ceil((d - today)/(1000*60*60*24));
  return diff;
}

// rotating quotes (on Home) - displays rotating quotes on the home page
// call initQuotes(['q1','q2']) on page load
function initQuotes(quotes, elementId, intervalSec=60){
  const el = document.getElementById(elementId);
  if(!el || !quotes || !quotes.length) return;
  let idx = Math.floor(Math.random()*quotes.length);
  el.textContent = quotes[idx];
  setInterval(()=>{
    idx = (idx+1) % quotes.length;
    el.textContent = quotes[idx];
  }, intervalSec*1000);
}

// quick AI links (example) - predefined shortcuts for research and productivity tools
const AI_SHORTCUTS = [
  {name:"ChatGPT (research)", url:"https://chat.openai.com/"},
  {name:"Google Scholar", url:"https://scholar.google.com/"},
  {name:"Semantic Scholar", url:"https://www.semanticscholar.org/"},
  {name:"Wolfram Alpha", url:"https://www.wolframalpha.com/"}
];

// small DOM helper to create element - utility function for creating DOM elements
function el(tag, cls, text){
  const e = document.createElement(tag);
  if(cls) e.className = cls;
  if(text) e.textContent = text;
  return e;
}

// theme mode toggle logic - handles switching between white, dark, and grey themes
const THEME_KEY = "tm_color_mode";
const MODES = ["white", "dark", "grey"];

function applyMode(mode) {
  document.body.classList.remove(...MODES);
  document.body.classList.add(mode);
  localStorage.setItem(THEME_KEY, mode);
}

function toggleMode() {
  const currentMode = localStorage.getItem(THEME_KEY) || "white";
  const currentIndex = MODES.indexOf(currentMode);
  const nextIndex = (currentIndex + 1) % MODES.length;
  const nextMode = MODES[nextIndex];
  applyMode(nextMode);
  updateToggleIcon(nextMode);
}

function updateToggleIcon(mode) {
  const btn = document.getElementById("modeToggle");
  if (!btn) return;
  switch(mode) {
    case "dark":
      btn.textContent = "🌙";
      break;
    case "grey":
      btn.textContent = "🌗";
      break;
    default:
      btn.textContent = "🌓";
  }
}

// initialize theme on page load - sets up theme mode and event listeners
document.addEventListener("DOMContentLoaded", () => {
  const savedMode = localStorage.getItem(THEME_KEY) || "white";
  applyMode(savedMode);
  updateToggleIcon(savedMode);

  const btn = document.getElementById("modeToggle");
  if (btn) {
    btn.addEventListener("click", toggleMode);
  }
});

/* export functions for pages that load this file.
   (in this setup app.js is included before page-specific scripts)
   makes all functions and constants available globally via window.App
*/
window.App = {
  loadTasks, saveTasks, addTask, updateTask, removeTask,
  daysBetween, initQuotes, AI_SHORTCUTS, el,
  KEY_TASKS, KEY_PROJECTS, KEY_GRADES
};
