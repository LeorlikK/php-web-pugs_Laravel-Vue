/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: {
            myCoral: 'lightcoral',
            myGold: '#B99D61FF',
            myBlack: '#444444FF',
            myWhite: '#F5F5F5FF',
        },
        fontSize:{
            myHeaderFontSize: '16px',
        },
        fontFamily: {
            myRoboto: ['Roboto', 'sans-serif']
        },
    },
  },
  plugins: [],
}

