import type { TreeData } from './tree'

export type Config = {
	title: string
	description: string
	published: string
	units: Unit[]
}

export type Unit = {
	title: string
	description?: string
	links?: { title: string; url: string }[]
	image?: string
	open?: string
	include?: string[]
	console?: string
}

export type Project = Config & {
	name: string
}

export type UnitFiles = Record<string, TreeData[]> // per unit
