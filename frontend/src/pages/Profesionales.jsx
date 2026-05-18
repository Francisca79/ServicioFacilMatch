import { useEffect, useState } from "react";
import { useSearchParams } from "react-router-dom";

function Profesionales() {
  const [searchParams] = useSearchParams();

  const categorias = [
    "Todas las categorías",
    "Electricista",
    "Plomería",
    "Carpintería",
    "Pintura",
    "Jardinería",
    "Limpieza",
    "Reparaciones",
    "Construcción",
    "Diseño",
    "Programación",
    "Marketing",
    "Fotografía",
  ];

  const ordenes = [
    "Mejor valorados",
    "Más reseñas",
    "Precio: Menor a Mayor",
    "Precio: Mayor a Menor",
  ];

  const categoriaDesdeURL = searchParams.get("categoria");
  const categoriaInicial =
    categoriaDesdeURL && categorias.includes(categoriaDesdeURL)
      ? categoriaDesdeURL
      : "Todas las categorías";

  const [categoria, setCategoria] = useState(categoriaInicial);
  const [orden, setOrden] = useState("Mejor valorados");
  const [profesionales, setProfesionales] = useState([]);
  const [perfilAbierto, setPerfilAbierto] = useState(null);

  useEffect(() => {
    fetch("http://localhost:8080/sfm_api/profesionales.php")
      .then((response) => response.json())
      .then((data) => setProfesionales(data))
      .catch((error) => console.error("Error:", error));
  }, []);

  const eliminarProfesional = async (id) => {
    const confirmar = window.confirm("¿Seguro que deseas eliminar este perfil?");

    if (!confirmar) return;

    try {
      const response = await fetch(
        `http://localhost:8080/sfm_api/eliminar_profesional.php?id=${id}`,
        {
          method: "DELETE",
        }
      );

      const data = await response.json();

      if (data.success) {
        alert("Perfil eliminado correctamente");

        setProfesionales(
          profesionales.filter(
            (profesional) => profesional.id_profesional !== id
          )
        );
      } else {
        alert("Error al eliminar perfil");
      }
    } catch (error) {
      console.error(error);
      alert("Error de conexión");
    }
  };

  const obtenerIcono = (categoria) => {
    if (categoria === "Electricista") return "⚡";
    if (categoria === "Plomería") return "🔧";
    if (categoria === "Carpintería") return "🪵";
    if (categoria === "Pintura") return "🎨";
    if (categoria === "Jardinería") return "🌿";
    if (categoria === "Limpieza") return "🧼";
    if (categoria === "Construcción") return "🏗️";
    if (categoria === "Programación") return "💻";
    if (categoria === "Marketing") return "📢";
    if (categoria === "Fotografía") return "📷";
    return "🛠️";
  };

  const profesionalesFiltrados =
    categoria === "Todas las categorías"
      ? profesionales
      : profesionales.filter((p) => p.nombre_categoria === categoria);

  return (
    <main className="bg-gray-50 min-h-screen">
      <section className="bg-white border-b border-gray-200 px-6 py-12">
        <div className="max-w-7xl mx-auto">
          <h1 className="text-4xl font-extrabold text-gray-900 mb-8">
            Encuentra tu Profesional Ideal
          </h1>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div className="bg-gray-100 rounded-lg px-4 py-3 flex items-center gap-3">
              <span className="text-gray-400 text-xl">🔍</span>
              <input
                type="text"
                placeholder="Buscar por nombre, servicio o categoría..."
                className="bg-transparent outline-none w-full text-gray-700"
              />
            </div>

            <select
              value={categoria}
              onChange={(e) => setCategoria(e.target.value)}
              className="bg-gray-100 rounded-lg px-4 py-3 outline-none cursor-pointer"
            >
              {categorias.map((item) => (
                <option key={item} value={item}>
                  {item}
                </option>
              ))}
            </select>

            <select
              value={orden}
              onChange={(e) => setOrden(e.target.value)}
              className="bg-gray-100 rounded-lg px-4 py-3 outline-none cursor-pointer"
            >
              {ordenes.map((item) => (
                <option key={item} value={item}>
                  {item}
                </option>
              ))}
            </select>
          </div>

          <p className="mt-6 text-gray-600">
            Mostrando {profesionalesFiltrados.length} de{" "}
            {profesionales.length} profesionales
          </p>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-6 py-12">
        {profesionalesFiltrados.length === 0 ? (
          <div className="bg-white border border-gray-200 rounded-xl p-16 text-center shadow-sm">
            <h2 className="text-2xl font-bold text-gray-900 mb-3">
              No hay profesionales registrados
            </h2>

            <p className="text-gray-600 mb-8">
              Por el momento no hay profesionales registrados en esta categoría.
            </p>

            <div className="inline-block bg-blue-50 text-blue-700 px-5 py-3 rounded-lg font-semibold">
              Categoría seleccionada: {categoria}
            </div>
          </div>
        ) : (
          <div className="grid md:grid-cols-3 gap-8">
            {profesionalesFiltrados.map((p) => (
              <div
                key={p.id_profesional}
                className="bg-white border border-gray-200 rounded-xl p-8 shadow-sm"
              >
                <div className="flex items-center gap-4">
                  <img
                    src={
                      p.foto ||
                      "https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                    }
                    alt={p.nombre}
                    className="w-20 h-20 rounded-full object-cover"
                  />

                  <div>
                    <h3 className="text-xl font-bold text-gray-900">
                      {p.nombre}
                    </h3>

                    <p className="text-gray-600">
                      {obtenerIcono(p.nombre_categoria)} {p.nombre_categoria}
                    </p>

                    <p className="text-yellow-500 mt-1">
                      ⭐⭐⭐⭐⭐
                    </p>
                  </div>
                </div>

                <div className="mt-6 space-y-3 text-gray-700">
                  <p>📍 {p.ciudad}</p>
                  <p>📞 {p.telefono}</p>
                  <p>💼 {p.experiencia}</p>
                  <p>
                    {obtenerIcono(p.nombre_categoria)} {p.especialidad}
                  </p>
                </div>

                <p className="mt-6 text-gray-600">
                  {p.descripcion_servicio}
                </p>

                <div className="mt-6 border-t pt-4 flex justify-between">
                  <div>
                    <p className="text-blue-600 font-bold text-2xl">
                      ${p.precio_estimado}
                    </p>
                    <p className="text-sm text-gray-500">por servicio</p>
                  </div>

                  <div className="text-right text-sm text-gray-500">
                    <p>{p.modalidad}</p>
                    <p>{p.disponibilidad}</p>
                  </div>
                </div>

                <button
                  onClick={() =>
                    setPerfilAbierto(
                      perfilAbierto === p.id_profesional
                        ? null
                        : p.id_profesional
                    )
                  }
                  className="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold"
                >
                  Ver perfil
                </button>

                {perfilAbierto === p.id_profesional && (
                  <div className="mt-5 bg-blue-50 border border-blue-100 rounded-xl p-5 text-gray-700">
                    <h4 className="font-bold text-gray-900 mb-3">
                      Información completa
                    </h4>

                    <p>
                      <strong>Nombre:</strong> {p.nombre}
                    </p>
                    <p>
                      <strong>Categoría:</strong> {p.nombre_categoria}
                    </p>
                    <p>
                      <strong>Especialidad:</strong> {p.especialidad}
                    </p>
                    <p>
                      <strong>Experiencia:</strong> {p.experiencia}
                    </p>
                    <p>
                      <strong>Descripción:</strong> {p.descripcion_servicio}
                    </p>
                    <p>
                      <strong>Valoración:</strong> ⭐⭐⭐⭐⭐
                    </p>
                  </div>
                )}

                <button
                  onClick={() => eliminarProfesional(p.id_profesional)}
                  className="mt-4 w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl font-semibold"
                >
                  Eliminar perfil
                </button>
              </div>
            ))}
          </div>
        )}
      </section>
    </main>
  );
}

export default Profesionales;