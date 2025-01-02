import type { TreeData } from './tree'

/**
 * @deprecated
 */
export type Config = {
	title: string
	description: string
	published: string
	units: Unit[]
}
/**
 * @deprecated
 */
export type Unit = {
	title: string
	titleStyle?: string
	description?: string
	links?: { title: string; url: string }[]
	image?: string
	open?: string
	include?: string[]
	console?: string
}
/**
 * @deprecated
 */
export type Project = Config & {
	name: string
}
/**
 * @deprecated
 */
export type UnitFiles = Record<string, TreeData[]> // per unit


export type ProjectV2 = {
	name: string
	title: string
	description: string
	published: string
	units?: UnitV2[]
	code?: {
		open: string
		include: string[]
		units?: UnitV2[]
	}
}
export type UnitV2 = {
	title: string
	description?: string
	links?: { title: string; url: string }[]
	image?: string
	terminal?: string
}
export type CodeFiles = TreeData[]
