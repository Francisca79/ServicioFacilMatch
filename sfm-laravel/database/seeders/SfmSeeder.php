<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Mensaje;
use App\Models\Profesional;
use App\Models\Resena;
use App\Models\ServicioAdquirido;
use App\Models\User;
use Illuminate\Database\Seeder;

class SfmSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'SFM Admin',
            'email' => 'admin@sfm.com',
            'password' => '123456',
            'telefono' => '7777-7777',
            'ciudad' => 'San Miguel',
            'tipo_usuario' => 'admin',
        ]);

        $cliente = User::create([
            'name' => 'Francisca Bonilla',
            'email' => 'franciscabon233@gmail.com',
            'password' => '123456',
            'telefono' => '78570852',
            'ciudad' => 'San Miguel',
            'tipo_usuario' => 'cliente',
        ]);

        $categorias = [
            ['nombre_categoria' => 'Electricista', 'descripcion' => 'Servicios eléctricos residenciales'],
            ['nombre_categoria' => 'Plomería', 'descripcion' => 'Reparación e instalación de tuberías'],
            ['nombre_categoria' => 'Programación', 'descripcion' => 'Desarrollo de software'],
            ['nombre_categoria' => 'Diseñador Gráfico', 'descripcion' => 'Diseño de contenido visual'],
            ['nombre_categoria' => 'Pintura', 'descripcion' => 'Servicios de pintura residencial'],
            ['nombre_categoria' => 'Jardinería', 'descripcion' => 'Mantenimiento de jardines'],
            ['nombre_categoria' => 'Limpieza', 'descripcion' => 'Servicios de limpieza general'],
            ['nombre_categoria' => 'Construcción', 'descripcion' => 'Servicios de construcción'],
            ['nombre_categoria' => 'Marketing', 'descripcion' => 'Marketing digital y publicidad'],
            ['nombre_categoria' => 'Fotografía', 'descripcion' => 'Servicios fotográficos'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }

        $userCarlos = User::create([
            'name' => 'Carlos Méndez',
            'email' => 'carlos@sfm.com',
            'password' => '123456',
            'telefono' => '7850-1234',
            'ciudad' => 'San Miguel',
            'tipo_usuario' => 'profesional',
        ]);

        $fotoDefault = 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';

        $perfiles = [
            [
                'user_id' => $userCarlos->id,
                'nombre' => 'Carlos Méndez',
                'especialidad' => 'Instalaciones eléctricas',
                'precio_estimado' => 25.00,
                'descripcion' => 'Electricista con 5 años de experiencia en instalaciones residenciales e industriales.',
                'categoria_id' => 1,
                'telefono' => '7850-1234',
                'ciudad' => 'San Miguel',
                'experiencia' => '5 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Lunes a Viernes',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Ana Rodríguez',
                'especialidad' => 'Reparación de tuberías',
                'precio_estimado' => 20.00,
                'descripcion' => 'Plomera certificada con experiencia en emergencias y mantenimiento preventivo.',
                'categoria_id' => 2,
                'telefono' => '7850-5678',
                'ciudad' => 'San Miguel',
                'experiencia' => '3 años',
                'modalidad' => 'online y presencial',
                'disponibilidad' => 'Fines de semana',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Luis Garay',
                'especialidad' => 'Desarrollo web Laravel/Vue',
                'precio_estimado' => 45.00,
                'descripcion' => 'Desarrollador full stack especializado en aplicaciones web modernas.',
                'categoria_id' => 3,
                'telefono' => '7850-9012',
                'ciudad' => 'San Miguel',
                'experiencia' => '6 años',
                'modalidad' => 'online',
                'disponibilidad' => 'Lunes a Sábado',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'María Flores',
                'especialidad' => 'Branding y diseño de logos',
                'precio_estimado' => 35.00,
                'descripcion' => 'Diseñadora gráfica con portafolio en identidad visual para PYMEs.',
                'categoria_id' => 4,
                'telefono' => '7850-3456',
                'ciudad' => 'San Miguel',
                'experiencia' => '4 años',
                'modalidad' => 'online',
                'disponibilidad' => 'Martes a Viernes',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Roberto Sánchez',
                'especialidad' => 'Pintura interior y exterior',
                'precio_estimado' => 18.00,
                'descripcion' => 'Pintor profesional con acabados de alta calidad para hogares y oficinas.',
                'categoria_id' => 5,
                'telefono' => '7850-7890',
                'ciudad' => 'San Miguel',
                'experiencia' => '8 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Lunes a Viernes',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Elena Vásquez',
                'especialidad' => 'Diseño y mantenimiento de jardines',
                'precio_estimado' => 22.00,
                'descripcion' => 'Paisajista con enfoque en jardines residenciales y áreas verdes comerciales.',
                'categoria_id' => 6,
                'telefono' => '7850-2345',
                'ciudad' => 'San Miguel',
                'experiencia' => '5 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Miércoles a Domingo',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Pedro Amaya',
                'especialidad' => 'Limpieza profunda y mantenimiento',
                'precio_estimado' => 15.00,
                'descripcion' => 'Servicio de limpieza residencial y comercial con productos ecológicos.',
                'categoria_id' => 7,
                'telefono' => '7850-6789',
                'ciudad' => 'San Miguel',
                'experiencia' => '2 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Todos los días',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Jorge Castillo',
                'especialidad' => 'Remodelaciones y albañilería',
                'precio_estimado' => 30.00,
                'descripcion' => 'Maestro de obra con experiencia en ampliaciones y remodelaciones completas.',
                'categoria_id' => 8,
                'telefono' => '7850-1122',
                'ciudad' => 'San Miguel',
                'experiencia' => '10 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Lunes a Sábado',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Sofía Mendoza',
                'especialidad' => 'Marketing digital y redes sociales',
                'precio_estimado' => 40.00,
                'descripcion' => 'Estratega digital para campañas en Facebook, Instagram y Google Ads.',
                'categoria_id' => 9,
                'telefono' => '7850-3344',
                'ciudad' => 'San Miguel',
                'experiencia' => '4 años',
                'modalidad' => 'online',
                'disponibilidad' => 'Lunes a Viernes',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Diego Herrera',
                'especialidad' => 'Fotografía de eventos',
                'precio_estimado' => 50.00,
                'descripcion' => 'Fotógrafo profesional para bodas, quinceañeras y eventos corporativos.',
                'categoria_id' => 10,
                'telefono' => '7850-5566',
                'ciudad' => 'San Miguel',
                'experiencia' => '7 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Fines de semana',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Miguel Torres',
                'especialidad' => 'Instalaciones industriales',
                'precio_estimado' => 35.00,
                'descripcion' => 'Electricista industrial especializado en tableros y cableado de alta capacidad.',
                'categoria_id' => 1,
                'telefono' => '7850-7788',
                'ciudad' => 'San Miguel',
                'experiencia' => '12 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Lunes a Viernes',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Karla Rivas',
                'especialidad' => 'Apps móviles Android/iOS',
                'precio_estimado' => 55.00,
                'descripcion' => 'Desarrolladora móvil con experiencia en Flutter y React Native.',
                'categoria_id' => 3,
                'telefono' => '7850-9900',
                'ciudad' => 'San Miguel',
                'experiencia' => '5 años',
                'modalidad' => 'online y presencial',
                'disponibilidad' => 'Lunes a Viernes',
                'foto' => $fotoDefault,
            ],
            [
                'user_id' => null,
                'nombre' => 'Andrea Luna',
                'especialidad' => 'Retratos y fotografía corporativa',
                'precio_estimado' => 42.00,
                'descripcion' => 'Fotógrafa especializada en retratos profesionales y sesiones de producto.',
                'categoria_id' => 10,
                'telefono' => '7850-1212',
                'ciudad' => 'San Miguel',
                'experiencia' => '3 años',
                'modalidad' => 'presencial',
                'disponibilidad' => 'Martes a Sábado',
                'foto' => $fotoDefault,
            ],
        ];

        $admin = User::where('tipo_usuario', 'admin')->first();

        $zonas = \App\Support\ZonasSanMiguel::todas();
        $profesionales = collect();
        foreach ($perfiles as $i => $perfil) {
            $base = $perfil['precio_estimado'];
            $profesionales->push(Profesional::create(array_merge($perfil, [
                'calificacion' => 0,
                'precio_min' => $base,
                'precio_max' => round($base * 2.5, 2),
                'zona' => $zonas[$i % count($zonas)],
            ])));
        }

        $resenas = [
            [0, 5, 'Excelente servicio eléctrico, muy puntual y profesional.'],
            [1, 4, 'Resolvió la fuga rápidamente. Muy recomendada.'],
            [2, 5, 'Entregó el proyecto web antes de lo previsto. Código limpio y bien documentado.'],
            [3, 5, 'El logo quedó perfecto, capturó exactamente la esencia de mi negocio.'],
            [4, 4, 'Buen trabajo de pintura, acabados uniformes y limpios.'],
            [5, 5, 'Transformó completamente mi jardín. Muy creativa y detallista.'],
            [6, 4, 'Limpieza impecable, llegó puntual y dejó todo ordenado.'],
            [7, 5, 'Remodelación excelente, cumplió plazos y presupuesto acordado.'],
            [8, 4, 'Aumentó mis ventas en redes sociales en el primer mes.'],
            [9, 5, 'Fotos de boda espectaculares, capturó cada momento especial.'],
            [10, 4, 'Instalación industrial sin contratiempos, muy experimentado.'],
            [11, 5, 'App móvil funcional y moderna, superó mis expectativas.'],
            [12, 4, 'Retratos corporativos de alta calidad, muy profesional.'],
            [0, 4, 'Segunda vez que contrato a Carlos, siempre confiable.'],
            [2, 4, 'Buena comunicación durante todo el desarrollo del sitio.'],
            [7, 4, 'Buena calidad en la construcción del muro perimetral.'],
        ];

        foreach ($resenas as [$indice, $calificacion, $comentario]) {
            Resena::create([
                'user_id' => $cliente->id,
                'profesional_id' => $profesionales[$indice]->id,
                'calificacion' => $calificacion,
                'comentario' => $comentario,
            ]);
        }

        foreach ($profesionales as $profesional) {
            $profesional->actualizarCalificacion();
        }

        $carlos = $profesionales[0];

        ServicioAdquirido::create([
            'user_id' => $cliente->id,
            'profesional_id' => $carlos->id,
            'verificado' => true,
            'verificado_por' => $admin->id,
            'notas' => 'Instalación eléctrica completada — puede reseñar',
        ]);

        ServicioAdquirido::create([
            'user_id' => $cliente->id,
            'profesional_id' => $profesionales[1]->id,
            'verificado' => true,
            'verificado_por' => $admin->id,
            'notas' => 'Reparación de tubería completada',
        ]);

        $mensajeContacto = Contacto::create([
            'user_id' => $cliente->id,
            'profesional_id' => $carlos->id,
            'nombre' => $cliente->name,
            'correo' => $cliente->email,
            'mensaje' => 'Hola Carlos, necesito revisar la instalación eléctrica de mi cocina. ¿Cuándo podrías visitarme?',
        ]);

        Mensaje::create([
            'remitente_id' => $cliente->id,
            'destinatario_id' => $userCarlos->id,
            'profesional_id' => $carlos->id,
            'asunto' => 'Solicitud de servicio — '.$cliente->name,
            'cuerpo' => $mensajeContacto->mensaje,
            'tipo' => 'solicitud',
        ]);
    }
}
