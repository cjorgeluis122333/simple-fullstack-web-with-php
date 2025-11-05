const API_URL = "http://localhost/project_php/ApiPhp.php";

const tabla = document.querySelector("#tablaUsuarios tbody");
const modal = document.getElementById("modalUsuario");
const form = document.getElementById("formUsuario");
const btnNuevo = document.getElementById("btnNuevo");
const btnCerrar = document.getElementById("btnCerrar");

// 🔹 Cargar todos los usuarios
async function cargarUsuarios() {
    const res = await fetch(API_URL);
    const data = await res.json();
    tabla.innerHTML = "";

    if (data.length === 0) {
        tabla.innerHTML = `<tr><td colspan="5">No hay usuarios registrados</td></tr>`;
        return;
    }

    data.forEach(u => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
      <td>${u.id}</td>
      <td>${u.nombre}</td>
      <td>${u.correo}</td>
      <td>${u.rol}</td>
      <td><button class="btn-danger" data-id="${u.id}">Eliminar</button></td>
    `;
        tabla.appendChild(tr);
    });

    document.querySelectorAll(".btn-danger").forEach(btn => {
        btn.addEventListener("click", eliminarUsuario);
    });
}

// 🔹 Insertar nuevo usuario
form.addEventListener("submit", async e => {
    e.preventDefault();

    const usuario = {
        nombre: form.nombre.value.trim(),
        correo: form.correo.value.trim(),
        rol: form.rol.value
    };

    if (!usuario.nombre || !usuario.correo) {
        alert("Por favor completa todos los campos.");
        return;
    }

    const res = await fetch(API_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(usuario)
    });

    if (res.ok) {
        modal.close();
        form.reset();
        cargarUsuarios();
    } else {
        alert("Error al insertar usuario.");
    }
});

// 🔹 Eliminar usuario
async function eliminarUsuario(e) {
    const id = e.target.dataset.id;
    if (!confirm("¿Seguro que quieres eliminar este usuario?")) return;

    await fetch(`${API_URL}?id=${id}`, { method: "DELETE" });
    cargarUsuarios();
}

// 🔹 Control del modal
btnNuevo.onclick = () => modal.showModal();
btnCerrar.onclick = () => modal.close();

// 🔹 Inicialización
cargarUsuarios();
