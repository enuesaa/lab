const std = @import("std");
const CLI = @import("cli.zig").CLI;

pub fn main() !void {
    var gpa = std.heap.GeneralPurposeAllocator(.{}){};
    defer _ = gpa.deinit();
    const allocator = gpa.allocator();

    const args = try std.process.argsAlloc(allocator);
    defer std.process.argsFree(allocator, args);

    var cli = CLI.init(allocator, "sampleapp", "very sample app");
    defer cli.deinit();
    cli.usage = "sampleapp <text>";

    const helpFlag = try cli.flagBool("--help", "show help");
    const versionFlag = try cli.flagBool("--version", "show version");
    versionFlag.alias = "-v";

    const err = cli.parse(args);
    if (err != null) {
        std.debug.print("error: {s}: {s}\n", .{ err.?.name, err.?.arg });
        return;
    }
    if (helpFlag.is) {
        const helpText = try cli.generateHelpText();
        std.debug.print("{s}\n", .{helpText});
        return;
    }
    if (versionFlag.is) {
        std.debug.print("v0.0.1\n", .{});
        return;
    }
    if (cli.positionals.items.len > 1) {
        std.debug.print("error: too many positional arguments.\n", .{});
        return;
    }
    if (cli.positionals.items.len == 0) {
        std.debug.print("error: missing positional arguments.\n", .{});
        return;
    }
    const text = cli.positionals.items[0];
    std.debug.print("ok\n", .{});
    std.debug.print("text: {s}\n", .{text});
}
