module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
  theme: {
    extend: {
        colors: {
            'palette': {
                1: '#1A374D',
                2: '#406882',
                3: '#6998AB',
                4: '#B1D0E0',
            },
            // ...
        },
    },
  },
  plugins: [],
}
