import { useState } from "react";
import { useNavigate } from "react-router-dom";

function Login() {
  const navigate = useNavigate();

  const [form, setForm] = useState({
    correo: "",
    contrasena: "",
  });

  const cambiarDato = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  };

  const iniciarSesion = async (e) => {
    e.preventDefault();

    try {
      const response = await fetch("http://localhost:8080/sfm_api/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(form),
      });

      const data = await response.json();

      if (data.success) {
        localStorage.setItem("usuario", JSON.stringify(data.usuario));
        alert("Inicio de sesión correcto");
        navigate("/");
      } else {
        alert("Correo o contraseña incorrectos");
      }
    } catch {
  alert("Error de conexión");
}
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100 px-6">
      <div className="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
        <h1 className="text-3xl font-bold text-center mb-8">
          Iniciar Sesión
        </h1>

        <form onSubmit={iniciarSesion} className="space-y-5">
          <div>
            <label className="block mb-2 font-medium">
              Correo Electrónico
            </label>

            <input
              name="correo"
              value={form.correo}
              onChange={cambiarDato}
              type="email"
              placeholder="correo@gmail.com"
              className="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none"
              required
            />
          </div>

          <div>
            <label className="block mb-2 font-medium">
              Contraseña
            </label>

            <input
              name="contrasena"
              value={form.contrasena}
              onChange={cambiarDato}
              type="password"
              placeholder="********"
              className="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none"
              required
            />
          </div>

          <button
            type="submit"
            className="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold"
          >
            Iniciar Sesión
          </button>
        </form>
      </div>
    </div>
  );
}

export default Login;