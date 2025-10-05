const std = @import("std");

pub fn shell() !void {
    const alloc = std.heap.page_allocator;

    const argv = &[_][]const u8{"zsh"};

    // https://github.com/99designs/aws-vault/blob/d4706c87383ca9ac8492c48e2d8a84dbd7e6cc07/cli/exec.go#L324
    // こんな感じのコードがあったほうがいいかも
    //    shell := os.Getenv("SHELL")
    // if shell == "" {
    //     shell = "/bin/sh" // fallback
    // }
    var child = std.process.Child.init(argv, alloc);

    const cwd = std.fs.cwd();

    const launchdir = try cwd.openDir("src", .{}); // ここに絶対パスを指定可能 (/Users/aaa/tmp)
    child.cwd_dir = launchdir;

    var env_map = try std.process.getEnvMap(alloc);
    try env_map.put("AAA", "bbb");
    child.env_map = &env_map;

    const exit_code = try child.spawnAndWait();
    std.debug.print("Exit code: {}\n", .{exit_code});
}
