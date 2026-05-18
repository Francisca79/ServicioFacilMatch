import { Link } from "react-router-dom";

function Home() {
  const categorias = [
    "Plomería",
    "Electricidad",
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

  return (
    <main>
      <section className="bg-blue-50 py-28 text-center px-6">
        <h1 className="text-5xl md:text-6xl font-extrabold text-gray-900 max-w-4xl mx-auto leading-tight">
          Encuentra al Profesional Perfecto para tu Proyecto
        </h1>

        <p className="mt-8 text-xl text-gray-700 max-w-3xl mx-auto">
          Conecta con profesionales calificados, verifica sus reseñas y contrata
          con confianza.
        </p>

        <div className="mt-10 bg-white max-w-3xl mx-auto p-5 rounded-xl shadow-lg flex gap-4">
          <input
            type="text"
            placeholder="🔍 ¿Qué servicio necesitas? Ej. Plomero, Electricista..."
            className="flex-1 bg-gray-100 px-5 py-4 rounded-lg outline-none"
          />

          <Link
            to="/profesionales"
            className="bg-gray-950 text-white px-8 rounded-lg font-semibold flex items-center"
          >
            Buscar
          </Link>
        </div>

        <div className="mt-10 flex justify-center gap-12 text-gray-700">
          <p>✅ Miles de profesionales</p>
          <p>✅ Reseñas verificadas</p>
          <p>✅ Respuesta rápida</p>
        </div>
      </section>

      <section className="py-20 px-6">
        <h2 className="text-3xl font-bold text-center mb-12">
          Categorías Populares
        </h2>

        <div className="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-6 gap-5">
          {categorias.map((categoria, index) => (
            <Link
              to={`/profesionales?categoria=${encodeURIComponent(categoria)}`}
              key={index}
              className="border border-gray-200 rounded-xl p-8 text-center shadow-sm hover:shadow-md transition hover:-translate-y-1"
            >
              <div className="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl">
                ⚡
              </div>

              <h3 className="font-semibold text-gray-900">{categoria}</h3>
            </Link>
          ))}
        </div>
      </section>

      <section className="bg-gray-50 py-20 px-6">
        <h2 className="text-3xl font-bold text-center mb-12">
          ¿Por qué elegir SFM?
        </h2>

        <div className="max-w-4xl mx-auto grid md:grid-cols-3 gap-8">
          <div className="bg-white border rounded-xl p-10 text-center shadow-sm">
            <div className="text-4xl mb-6">🛡️</div>

            <h3 className="font-bold text-xl mb-4">
              Profesionales Verificados
            </h3>

            <p className="text-gray-600">
              Todos nuestros profesionales pasan por un proceso de verificación.
            </p>
          </div>

          <div className="bg-white border rounded-xl p-10 text-center shadow-sm">
            <div className="text-4xl mb-6">⭐</div>

            <h3 className="font-bold text-xl mb-4">Reseñas Reales</h3>

            <p className="text-gray-600">
              Lee opiniones verificadas de clientes antes de contratar.
            </p>
          </div>

          <div className="bg-white border rounded-xl p-10 text-center shadow-sm">
            <div className="text-4xl mb-6">🕒</div>

            <h3 className="font-bold text-xl mb-4">Respuesta Rápida</h3>

            <p className="text-gray-600">
              Los profesionales responden en promedio en menos de 2 horas.
            </p>
          </div>
        </div>
      </section>

      <section className="py-20 text-center px-6">
        <h2 className="text-3xl font-bold mb-12">Cómo funciona</h2>

        <div className="max-w-4xl mx-auto grid md:grid-cols-3 gap-10">
          <div>
            <div className="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 font-bold">
              1
            </div>

            <h3 className="font-bold">Busca</h3>

            <p className="text-gray-600 mt-2">
              Encuentra profesionales por categoría, ubicación o servicio.
            </p>
          </div>

          <div>
            <div className="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 font-bold">
              2
            </div>

            <h3 className="font-bold">Compara</h3>

            <p className="text-gray-600 mt-2">
              Revisa perfiles, reseñas, calificaciones y precios.
            </p>
          </div>

          <div>
            <div className="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 font-bold">
              3
            </div>

            <h3 className="font-bold">Contrata</h3>

            <p className="text-gray-600 mt-2">
              Contacta directamente al profesional que mejor se adapte.
            </p>
          </div>
        </div>
      </section>

      <section className="bg-blue-600 text-white text-center py-16 px-6">
        <h2 className="text-3xl font-bold">¿Eres un Profesional?</h2>

        <p className="mt-4 text-lg">
          Únete a nuestra plataforma y conecta con más clientes potenciales.
        </p>

        <Link
          to="/registro"
          className="inline-block mt-8 bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold"
        >
          Regístrate como Profesional
        </Link>
      </section>
    </main>
  );
}

export default Home;