function Footer() {
  return (
    <footer className="bg-gray-950 text-white py-12 px-6">
      <div className="max-w-6xl mx-auto grid md:grid-cols-4 gap-10">
        <div>
          <div className="flex items-center gap-2 mb-4">
            <div className="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold">
              S
            </div>
            <h3 className="font-bold text-xl">SFM</h3>
          </div>
          <p className="text-gray-400">
            Conectamos clientes con profesionales calificados para cualquier trabajo.
          </p>
        </div>

        <div>
          <h4 className="font-bold mb-4">Plataforma</h4>
          <p className="text-gray-400">Buscar Profesionales</p>
          <p className="text-gray-400">Cómo funciona</p>
          <p className="text-gray-400">Conviértete en Profesional</p>
        </div>

        <div>
          <h4 className="font-bold mb-4">Empresa</h4>
          <p className="text-gray-400">Acerca de</p>
          <p className="text-gray-400">Blog</p>
          <p className="text-gray-400">Contacto</p>
        </div>

        <div>
          <h4 className="font-bold mb-4">Legal</h4>
          <p className="text-gray-400">Términos de uso</p>
          <p className="text-gray-400">Privacidad</p>
          <p className="text-gray-400">Galletas</p>
        </div>
      </div>

      <div className="max-w-6xl mx-auto border-t border-gray-800 mt-10 pt-6 text-center text-gray-400">
        © 2026 SFM. Todos los derechos reservados.
      </div>
    </footer>
  );
}

export default Footer;
