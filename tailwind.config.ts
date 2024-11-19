import { type Config } from 'tailwindcss'

export default {
	content: ['src/**/*.svelte', 'src/app.html'],
	theme: {
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
	},
	darkMode: 'class',
} satisfies Config
