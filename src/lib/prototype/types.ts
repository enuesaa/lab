import type { TreeData } from './tree'

export type ProjectV2 = {
	name: string
	title: string
	description: string
	published: string
	units: UnitV2[]
}
export type UnitV2 = {
	title?: string
	description?: string
	links?: { title: string; url: string }[]
	image?: string
	terminal?: string
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
