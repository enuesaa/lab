import type { TreeData } from './tree'

export type Config = {
	title: string
	description: string
	published: string
	units: Unit[]
}

export type Unit = {
	name: string
	title: string
	description?: string
	image?: string
	filetree?: {
		open: string
		ignore: string[]
	}
	terminal?: {
		description: string
		console: string
	}
}

export type Project = Config & {
	name: string
}

export type UnitFiles = Record<string, TreeData[]> // per unit
