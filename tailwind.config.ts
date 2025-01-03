import { type Config } from 'tailwindcss'

export default {
	content: ['src/**/*.svelte', 'src/app.html'],
	theme: {
		extend: {
			colors: {
				black: '#1a1a1a',
				blackgray: '#2a2a2a',
				gray: '#cccccc',
				graywhite: '#dadada',
				grayblacker: '#bfbfbf',
				grayblack: '#b3b3b3',
				white: '#fafafa',
				editorbg: '#22272e',
				editortext: '#adbac7',
				editorsep: '#4a5666',
			},
			fontFamily: {
				zenmaru: ['Zen Maru Gothic', 'serif'],
				ibmplex: ['"IBM Plex Sans JP"', 'sans-serif'],
			},
			boxShadow: {
				/** 2xl uppper */
				'2xlu': 'box-shadow: 0 25px 50px -25px rgb(0 0 0 / 0.25);'
			},
		},
	},
	darkMode: 'class',
} satisfies Config
