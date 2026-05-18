import { useState } from "react";

function Profesionales() {
  const [categoria, setCategoria] = useState("Todas las categorías");
  const [orden, setOrden] = useState("Mejor valorados");

  const categorias = {
  Plomería: 1,
  Electricidad: 2,
  Carpintería: 3,
  Pintura: 4,
  Jardinería: 5,
  Limpieza: 6,
  Reparaciones: 7,
  Construcción: 8,
  Diseño: 9,
  Programación: 10,
  Marketing: 11,
  Fotografía: 12,
};
  const ordenes = [
    "Mejor valorados",
    "Más reseñas",
    "Precio: Menor a Mayor",
    "Precio: Mayor a Menor",
  ];

  const profesionales = [];

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
              {categorias.map((item, index) => (
                <option key={index} value={item}>
                  {item}
                </option>
              ))}
            </select>

            <select
              value={orden}
              onChange={(e) => setOrden(e.target.value)}
              className="bg-gray-100 rounded-lg px-4 py-3 outline-none cursor-pointer"
            >
              {ordenes.map((item, index) => (
                <option key={index} value={item}>
                  {item}
                </option>
              ))}
            </select>
          </div>

          <p className="mt-6 text-gray-600">
            Mostrando {profesionales.length} de {profesionales.length} profesionales
          </p>
        </div>
      </section>

      <section className="max-w-7xl mx-auto px-6 py-12">
        {profesionales.length === 0 ? (
          <div className="bg-white border border-gray-200 rounded-xl p-16 text-center shadow-sm">
            <h2 className="text-2xl font-bold text-gray-900 mb-3">
              No hay profesionales registrados
            </h2>

            <p className="text-gray-600 mb-8">
              Por el momento esta sección está vacía. Cuando se registren
              profesionales, aparecerán aquí según la categoría seleccionada.
            </p>

            <div className="inline-block bg-blue-50 text-blue-700 px-5 py-3 rounded-lg font-semibold">
              Categoría seleccionada: {categoria}
            </div>

            <div className="mt-4 inline-block bg-gray-100 text-gray-700 px-5 py-3 rounded-lg font-semibold ml-3">
              Orden: {orden}
            </div>
          </div>
        ) : (
          <div className="grid md:grid-cols-3 gap-8">
            {profesionales.map((profesional) => (
              <div
                key={profesional.id}
                className="bg-white border border-gray-200 rounded-xl p-8 shadow-sm"
              >
                <h3>{profesional.nombre}</h3>
              </div>
            ))}
          </div>
        )}
      </section>
    </main>
  );
}

export default Profesionales;