import { Link } from "react-router-dom";

function Navbar() {
  return (
    <header className="bg-white border-b border-gray-200">
      <nav className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <Link to="/" className="flex items-center gap-2">
          <div className="bg-blue-600 text-white w-10 h-10 rounded-lg flex items-center justify-center font-bold text-xl">
            S
          </div>
          <span className="font-bold text-2xl text-gray-900">SFM</span>
        </Link>

        <div className="hidden md:flex gap-8 text-gray-800 font-medium">
          <Link to="/">Inicio</Link>
          <Link to="/profesionales">Explorar Profesionales</Link>
          <Link to="/categorias">Categorías</Link>
        </div>

        <div className="flex items-center gap-4">
          <Link to="/login" className="font-semibold text-gray-900">
            Iniciar Sesión
          </Link>

          <Link
            to="/registro"
            className="bg-gray-950 text-white px-5 py-2 rounded-lg font-semibold"
          >
            Registrarse
          </Link>
        </div>
      </nav>
    </header>
  );
}

export default Navbar;