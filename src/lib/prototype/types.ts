import type { TreeData } from './tree'

export type ProjectV2 = {
	name: string
	title: string
	description: string
	published: string
	units: UnitV2[]
}
export type UnitV2 = {
	as?: string
	cap?: string
	title?: string
	description?: string
	links?: { title: string; url: string }[]
	image?: string
	terminal?: string
	outline?: Outline
	code?: {
		open: string
		include: string[]
		units?: CodeUnit[]
		files?: CodeFiles
	}
	inline?: {
		open: string
		file?: TreeData
	}
}
export type Outline = {
	title?: string
	items: {
		title: string
		as: string
	}[]
}
export type CodeUnit = {
	title?: string
	description?: string
	links?: { title: string; url: string }[]
	terminal?: string
	inline?: {
		open: string
		file?: TreeData
	}
	mark?: string
}

export type CodeFiles = TreeData[]
