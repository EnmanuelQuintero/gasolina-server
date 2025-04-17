





 




    document.addEventListener('DOMContentLoaded', () => {
        // Inicializa los modales
        const modals = document.querySelectorAll('[data-modal-toggle]');
        modals.forEach(modalToggle => {
            const targetId = modalToggle.getAttribute('data-modal-toggle');
            const targetModal = document.getElementById(targetId);
    
            if (targetModal) {
                // Mostrar el modal
                modalToggle.addEventListener('click', () => {
                    targetModal.classList.remove('hidden');
                });
    
                // Cerrar el modal
                targetModal.querySelector('[data-modal-toggle]').addEventListener('click', () => {
                    targetModal.classList.add('hidden');
                });
            }
        });
    });
    
    
    function imprimir(modalId) {
            // Obtener el modal que está abierto actualmente usando su ID
            var modal = document.getElementById(modalId);
            // Copiar el contenido del modal
            var contenido = modal.innerHTML;
    
            var ventana = window.open('', '', `height=${screen.height},width=${screen.width}`);
            
            ventana.document.write('<html><head><title>Imprimir</title>');
            
            // Incluir el CSS de Tailwind y algunos estilos básicos para asegurarnos de que se mantenga la estructura
            ventana.document.write('<style>');
            ventana.document.write(`
                body { font-family: Arial, sans-serif; margin: 0; padding: 30px; width:47%; }
                .abajo-45{margin-left:40px;}
                .columna{border-right:solid 2px black;}
                .medio{margin-bottom:15px;}
                .tx-total{margin-right:15px;}
                .arriba{position:absolute; top:0; width:43%;}
                .derecha{display:flex; justify-content:end;}
                .pie_pagina{position:absolute; bottom:0; width:45%; margin-bottom:10px; margin-top:30px;}
                .total{border:solid 2px black; width:92%; padding-right:15px; margin-bottom:30px; font-weight:bold;}
                .tabla{border:2px solid black; margin-top:35%; width:95% }
                .encabezado{ height:30px; border-bottom:solid 2px black;}
                .superior-alcaldia{height:70px; width:70px; margin-right:80px;}
                .superior-45{height:80px; width:80px; margin-left:40px;}
                .qr{ width:70px; height:70px;}
                .grid { display: grid; }
                .grid-cols-3 { grid-template-columns: repeat(3, 1fr); place-items:center }
                .grid-cols-6 { grid-template-columns: repeat(6, 1fr); }
                .text-center { text-align: center; }
                .text-end { text-align: end; }
                .my-9 { margin: 18px 0; }
                .gap-4 { gap: 8px; }
                .border-solid { border-style: solid; }
                .border-2 { border-width: 1px; }
                .border-gray-700 { border-color: #4a5568; }
                .w-full { width: 100%; }
                .w-52 { width: 10rem; } /* Se redujo el ancho */
                .float-start { float: left; }
                .float-end { float: right; }
                .rounded { border-radius: 0.25rem; }
                .bg-white { background-color: white; }
                .p-6 { padding: 1rem; } /* Se redujo el padding */
                .m-4 { margin: 0.5rem; } /* Se redujo el margin */
                button{display:none;}
                h3, h4, p, label { font-size: 12px; } /* Se redujo el tamaño de fuente */
                .ts{font-size:14px; font-weight:bolder; }
                .xd{width:120%; overflow:visible;}
            `);
            ventana.document.write('</style>');
            
            ventana.document.write('</head><body>');
            ventana.document.write(contenido);
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.focus(); // necesario para algunos navegadores
            ventana.print();
            ventana.close();
        }
    
    