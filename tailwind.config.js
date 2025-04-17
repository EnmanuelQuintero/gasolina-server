/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
     "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors:
      {
        azul: '#3B7FD9',
        azulObscuro: '#023E73',
        rojo:'#BD2A2E',
        amarillo: '#FF9933',
        azultarjeta:'#0099DD',
      }
    },
  },
  plugins: [
    require('flowbite/plugin')({
      datatables: true,
  }),
  ],
}

