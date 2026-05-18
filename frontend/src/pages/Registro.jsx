import { useState } from "react";

function Registro() {
  const [form, setForm] = useState({
    nombre: "",
    correo: "",
    contrasena: "",
    telefono: "",
    ciudad: "",
    categoria: "",
    experiencia: "",
    especialidades: "",
    precio: "",
    modalidad: "",
    disponibilidad: "",
    descripcion: "",
    foto: "",
  });

  const cambiarDato = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  };

  const registrarProfesional = async (e) => {
    e.preventDefault();

    try {
      const responseUsuario = await fetch(
        "http://localhost:8080/sfm_api/registro.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            nombre: form.nombre,
            correo: form.correo,
            contrasena: form.contrasena,
            telefono: form.telefono,
            ciudad: form.ciudad,
            tipo_usuario: "profesional",
          }),
        }
      );

      const dataUsuario = await responseUsuario.json();

      if (!dataUsuario.success) {
        alert(dataUsuario.message);
        return;
      }

      const responseProfesional = await fetch(
        "http://localhost:8080/sfm_api/guardar_profesional.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_usuario: dataUsuario.id_usuario,
            id_categoria: form.categoria,
            especialidad: form.especialidades,
            experiencia: form.experiencia,
            descripcion_servicio: form.descripcion,
            precio_estimado: form.precio,
            modalidad: form.modalidad,
            disponibilidad: form.disponibilidad,
            foto: form.foto,
          }),
        }
      );

      const dataProfesional = await responseProfesional.json();

      if (dataProfesional.success) {
        alert("Perfil profesional creado correctamente");

        setForm({
          nombre: "",
          correo: "",
          contrasena: "",
          telefono: "",
          ciudad: "",
          categoria: "",
          experiencia: "",
          especialidades: "",
          precio: "",
          modalidad: "",
          disponibilidad: "",
          descripcion: "",
          foto: "",
        });
      } else {
        alert(dataProfesional.message);
      }
    } catch {
      alert("Error de conexión");
    }
  };

  return (
    <main className="bg-gray-100 min-h-screen py-12 px-6">
      <section className="max-w-5xl mx-auto bg-white rounded-2xl shadow-md p-10">
        <h1 className="text-4xl font-bold mb-10 text-center">
          Registro Profesional
        </h1>

        <form onSubmit={registrarProfesional} className="space-y-8">
          <div className="grid md:grid-cols-2 gap-5">
            <input
              type="text"
              name="nombre"
              placeholder="Nombre completo"
              value={form.nombre}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
              required
            />

            <input
              type="email"
              name="correo"
              placeholder="Correo electrónico"
              value={form.correo}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
              required
            />

            <input
              type="password"
              name="contrasena"
              placeholder="Contraseña"
              value={form.contrasena}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
              required
            />

            <input
              type="text"
              name="telefono"
              placeholder="Teléfono"
              value={form.telefono}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
              required
            />

            <input
              type="text"
              name="ciudad"
              placeholder="Ciudad"
              value={form.ciudad}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
              required
            />

            <select
              name="categoria"
              value={form.categoria}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
              required
            >
              <option value="">Seleccione categoría</option>
              <option value="1">Electricista</option>
              <option value="2">Plomero</option>
              <option value="3">Carpintero</option>
              <option value="4">Diseñador</option>
              <option value="5">Programador</option>
              <option value="6">Marketing</option>
              <option value="7">Fotografía</option>
              <option value="8">Jardinería</option>
              <option value="9">Limpieza</option>
              <option value="10">Construcción</option>
              
            </select>

            <input
              type="text"
              name="experiencia"
              placeholder="Experiencia"
              value={form.experiencia}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
            />

            <input
              type="text"
              name="especialidades"
              placeholder="Especialidad"
              value={form.especialidades}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
            />

            <input
              type="number"
              name="precio"
              placeholder="Precio"
              value={form.precio}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
            />

            <select
              name="modalidad"
              value={form.modalidad}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
            >
              <option value="">Modalidad</option>
              <option value="presencial">Presencial</option>
              <option value="online">Online</option>
              <option value="online y presencial">
                Online y presencial
              </option>
            </select>

            <input
              type="text"
              name="disponibilidad"
              placeholder="Disponibilidad"
              value={form.disponibilidad}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
            />

            <input
              type="text"
              name="foto"
              placeholder="URL de la foto"
              value={form.foto}
              onChange={cambiarDato}
              className="border border-gray-300 rounded-xl px-4 py-3 outline-none"
            />
          </div>

          <div>
            <label className="block text-lg font-semibold mb-3">
              Descripción del servicio
            </label>

            <textarea
              name="descripcion"
              value={form.descripcion}
              onChange={cambiarDato}
              rows="6"
              className="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none"
              placeholder="Describe tu servicio..."
            ></textarea>
          </div>

          <button
            type="submit"
            className="w-full bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-xl font-bold text-lg transition"
          >
            Crear perfil profesional
          </button>
        </form>
      </section>
    </main>
  );
}

export default Registro;