document.addEventListener("DOMContentLoaded", () => {
  const fadeElements = document.querySelectorAll(".fade-in");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }
    });
  });

  fadeElements.forEach(el => observer.observe(el));
});

const quizContainer = document.getElementById("quiz-container");

const quizData = [
  {
    question: "Qual instrumento você prefere?",
    options: ["Piano", "Violão", "Bateria", "Voz"]
  },
  {
    question: "Qual estilo te emociona mais?",
    options: ["Clássico", "Pop", "Rock", "Jazz"]
  }
];

function renderQuiz() {
  quizData.forEach((q, index) => {
    const div = document.createElement("div");
    div.classList.add("quiz-question", "fade-in");
    div.innerHTML = `<h4>${q.question}</h4>` + q.options.map(opt => `
      <button class="btn btn-outline-purple m-1">${opt}</button>
    `).join("");
    quizContainer.appendChild(div);
  });
}

renderQuiz();