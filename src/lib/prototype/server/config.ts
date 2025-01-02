import type { Config } from '$lib/prototype/types'
import fs from 'node:fs/promises'
import YAML from 'yaml'

/**
 * @deprecated
 */
export const readConfig = async (name: string): Promise<Config> => {
	const path = `./data/${name}/.prototype.yml`
	const text = await fs.readFile(path, 'utf8')

	return YAML.parse(text) as Config
}
