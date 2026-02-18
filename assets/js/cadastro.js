$(document).ready(function () {

  const regexSenha =
    /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

  const form = document.getElementById("formCadastro");
  const senhaInput = document.getElementById("senha");
  const erroSenha = document.querySelector(".erro-senha");

  /* ===============================
     FUNÇÕES SEGURAS
     =============================== */
  function mostrarErro(el) {
    if (!el) return;
    el.classList.remove("ativo");
    void el.offsetWidth;
    el.classList.add("ativo");
  }

  function esconderErro(el) {
    if (!el) return;
    el.classList.remove("ativo");
  }

  function erroObrigatorio(campo) {
    return document.querySelector(
      `.erro-obrigatorio[data-for="${campo.id}"]`
    );
  }

  /* ===============================
     SENHA
     =============================== */
  senhaInput.addEventListener("input", () => {
    regexSenha.test(senhaInput.value)
      ? esconderErro(erroSenha)
      : mostrarErro(erroSenha);
  });

  senhaInput.addEventListener("blur", () => {
    esconderErro(erroSenha);
  });

  /* ===============================
     OUTROS CAMPOS OBRIGATÓRIOS
     =============================== */
  document.querySelectorAll("[required]:not(#senha)").forEach((campo) => {

    campo.addEventListener("input", () => {
      if (campo.value.trim() !== "") {
        esconderErro(erroObrigatorio(campo));
      }
    });

    campo.addEventListener("blur", () => {
      esconderErro(erroObrigatorio(campo));
    });

  });

  /* ===============================
     SUBMIT
     =============================== */
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    let valido = true;

    document.querySelectorAll("[required]:not(#senha)").forEach((campo) => {
      if (campo.value.trim() === "") {
        mostrarErro(erroObrigatorio(campo));
        valido = false;
      }
    });

    if (!regexSenha.test(senhaInput.value)) {
      mostrarErro(erroSenha);
      valido = false;
    }

    if (!valido) {
      $("#msgErro").text("Preencha os campos obrigatórios.").show();
      return;
    }

    $.ajax({
      url: "assets/php/cadastro.php",
      type: "POST",
      data: $(form).serialize(),

      success: function (resposta) {
        resposta = resposta.trim();

        if (resposta === "sucesso") {
          $("#msgErro").hide();
          $("#msgSucesso").show();

          setTimeout(() => {
            window.location.href = "index.html";
          }, 1500);
        } else {
          $("#msgErro").text("Erro ao cadastrar.").show();
        }
      }
    });
  });

});
